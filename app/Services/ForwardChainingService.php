<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\FcRule;
use App\Models\QlcLevel;
use App\Models\Symptom;

/**
 * ForwardChainingService
 *
 * Mengimplementasikan metode Forward Chaining untuk mendeteksi
 * tingkat Quarter-Life Crisis (QLC) berdasarkan jawaban kuesioner Likert.
 *
 * Referensi Literatur:
 * - Petrov, Robinson & Arnett (2022) — DCQ-12: threshold skor ≥ 42 untuk krisis
 * - Robbins & Wilner (2001) — Definisi & dimensi QLC
 * - Atwood & Scholtz (2008) — Dimensi karir, identitas, relasi
 */
class ForwardChainingService
{
    // ─── Konversi Likert ke Poin ──────────────────────────────────────────────
    // Likert 1 (Tidak Pernah) = 0 poin
    // Likert 2 (Jarang)       = 1 poin
    // Likert 3 (Kadang-kadang)= 2 poin
    // Likert 4 (Sering)       = 3 poin
    // Likert 5 (Selalu)       = 4 poin
    // Total Maksimum          = 20 gejala × 4 poin = 80 poin

    /**
     * Proses utama Forward Chaining.
     *
     * @param  Assessment  $assessment  Sesi asesmen yang sudah memiliki jawaban
     * @return array  [
     *   'total_score'      => int,
     *   'base_level_score' => int,
     *   'qlc_level'        => QlcLevel,
     *   'dominant_domain'  => string,
     *   'domain_scores'    => array,
     *   'fc_rules_fired'   => array,
     * ]
     */
    public function process(Assessment $assessment): array
    {
        // 1. Ambil semua jawaban dengan relasi gejala (eager load)
        $answers = $assessment->answers()->with('symptom.category')->get();

        // 2. Hitung total skor dan skor per domain
        $totalScore  = 0;
        $domainScores = [];

        foreach ($answers as $answer) {
            $weightedScore = $answer->weighted_score; // sudah dihitung: likert - 1
            $totalScore   += $weightedScore;

            $domainCode = $answer->symptom->category->code ?? 'Unknown';
            $domainName = $answer->symptom->category->name ?? 'Unknown';
            if (!isset($domainScores[$domainCode])) {
                $domainScores[$domainCode] = ['name' => $domainName, 'score' => 0, 'max' => 0];
            }
            $domainScores[$domainCode]['score'] += $weightedScore;
            $domainScores[$domainCode]['max']   += 4; // maks 4 poin per gejala
        }

        // 3. Tentukan level dasar berdasarkan total skor
        $baseLevel = $this->getBaseLevel($totalScore);
        $baseLevelScore = $totalScore;

        // 4. Jalankan aturan Forward Chaining tambahan (gejala kritis)
        $firedRules = [];
        $finalLevel = $this->applyRules($answers, $baseLevel, $totalScore, $firedRules);

        // 5. Tentukan domain dominan
        $dominantDomain = $this->getDominantDomain($domainScores);

        return [
            'total_score'      => $totalScore,
            'base_level_score' => $baseLevelScore,
            'qlc_level'        => $finalLevel,
            'dominant_domain'  => $dominantDomain,
            'domain_scores'    => $domainScores,
            'fc_rules_fired'   => $firedRules,
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE METHODS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Tentukan level QLC dasar berdasarkan total skor.
     */
    private function getBaseLevel(int $totalScore): QlcLevel
    {
        return QlcLevel::where('score_min', '<=', $totalScore)
            ->where('score_max', '>=', $totalScore)
            ->first()
            ?? QlcLevel::where('code', 'none')->first();
    }

    /**
     * Terapkan aturan-aturan Forward Chaining tambahan.
     * Aturan bersifat forward (IF conditions → THEN action).
     *
     * @param  \Illuminate\Support\Collection  $answers
     * @param  QlcLevel  $baseLevel
     * @param  int  $totalScore
     * @param  array  &$firedRules  Referensi untuk mencatat rule yang aktif
     */
    private function applyRules($answers, QlcLevel $baseLevel, int $totalScore, array &$firedRules): QlcLevel
    {
        // Buat peta skor per kode gejala untuk lookup cepat
        $symptomScores = [];
        $criticalScores = [];

        foreach ($answers as $answer) {
            $code = $answer->symptom->code;
            $symptomScores[$code] = $answer->weighted_score;
            if ($answer->symptom->is_critical) {
                $criticalScores[$code] = $answer->weighted_score;
            }
        }

        // Ambil semua rule aktif, urut dari prioritas tertinggi (angka terkecil)
        $rules = FcRule::where('is_active', true)
            ->with(['conditions.symptom', 'targetLevel'])
            ->orderBy('priority')
            ->get();

        $currentLevel    = $baseLevel;
        $levelOrder      = ['none' => 0, 'mild' => 1, 'moderate' => 2, 'severe' => 3];
        $allLevels       = QlcLevel::orderBy('score_min')->get()->keyBy('code');

        foreach ($rules as $rule) {
            if ($this->evaluateConditions($rule, $symptomScores, $criticalScores, $totalScore)) {
                $firedRules[] = $rule->code;

                switch ($rule->action_type) {
                    case 'set_level':
                        // Tetapkan level secara langsung (hanya jika lebih tinggi dari saat ini)
                        if ($rule->targetLevel && $levelOrder[$rule->targetLevel->code] > $levelOrder[$currentLevel->code]) {
                            $currentLevel = $rule->targetLevel;
                        }
                        break;

                    case 'set_minimum':
                        // Naik ke level minimum yang ditentukan jika saat ini lebih rendah
                        if ($rule->targetLevel && $levelOrder[$rule->targetLevel->code] > $levelOrder[$currentLevel->code]) {
                            $currentLevel = $rule->targetLevel;
                        }
                        break;

                    case 'escalate_one':
                        // Naik satu tingkat dari level saat ini
                        $nextCode = $this->getNextLevelCode($currentLevel->code);
                        if ($nextCode && isset($allLevels[$nextCode])) {
                            $currentLevel = $allLevels[$nextCode];
                        }
                        break;
                }
            }
        }

        return $currentLevel;
    }

    /**
     * Evaluasi semua kondisi dari satu rule (AND logic — semua harus terpenuhi).
     */
    private function evaluateConditions(FcRule $rule, array $symptomScores, array $criticalScores, int $totalScore): bool
    {
        foreach ($rule->conditions as $condition) {
            $passed = match ($condition->condition_type) {
                'symptom_score' => $this->compareValue(
                    $symptomScores[$condition->symptom?->code ?? ''] ?? 0,
                    $condition->operator,
                    $condition->value
                ),
                'total_score'   => $this->compareValue($totalScore, $condition->operator, $condition->value),
                'critical_count' => $this->compareValue(
                    count(array_filter($criticalScores, fn ($s) => $s >= 3)),
                    $condition->operator,
                    $condition->value
                ),
                default         => false,
            };

            if (!$passed) {
                return false; // AND logic: satu kondisi gagal = rule tidak aktif
            }
        }

        return true; // Semua kondisi terpenuhi
    }

    /**
     * Bandingkan nilai menggunakan operator yang diberikan.
     */
    private function compareValue(int|float $actual, string $operator, int|float $threshold): bool
    {
        return match ($operator) {
            '>='    => $actual >= $threshold,
            '<='    => $actual <= $threshold,
            '>'     => $actual > $threshold,
            '<'     => $actual < $threshold,
            '='     => $actual == $threshold,
            default => false,
        };
    }

    /**
     * Dapatkan kode level berikutnya (naik satu tingkat).
     */
    private function getNextLevelCode(string $currentCode): ?string
    {
        $order = ['none' => 'mild', 'mild' => 'moderate', 'moderate' => 'severe', 'severe' => null];
        return $order[$currentCode] ?? null;
    }

    /**
     * Dapatkan domain dengan skor tertinggi (domain dominan).
     */
    private function getDominantDomain(array $domainScores): string
    {
        if (empty($domainScores)) return '-';

        $dominant = array_reduce(array_keys($domainScores), function ($carry, $key) use ($domainScores) {
            if ($carry === null || $domainScores[$key]['score'] > $domainScores[$carry]['score']) {
                return $key;
            }
            return $carry;
        });

        return $dominant ? ($domainScores[$dominant]['name'] ?? '-') : '-';
    }

    /**
     * Konversi skor Likert (1-5) ke weighted score (0-4).
     */
    public static function likertToWeighted(int $likert): int
    {
        return max(0, min(4, $likert - 1));
    }

    /**
     * Kembalikan daftar pilihan Likert untuk form kuesioner.
     */
    public static function getLikertChoices(): array
    {
        return [
            1 => 'Tidak Pernah',
            2 => 'Jarang',
            3 => 'Kadang-kadang',
            4 => 'Sering',
            5 => 'Selalu',
        ];
    }
}
