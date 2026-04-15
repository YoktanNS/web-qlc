<?php

namespace App\Services;

use App\Models\ActionPlan;
use App\Models\AssessmentResult;
use App\Models\SawCriteria;

/**
 * SAWService (Simple Additive Weighting)
 *
 * Mengimplementasikan metode SAW untuk meranking rekomendasi action plan
 * berdasarkan profil pengguna dan domain gejala dominan.
 *
 * Referensi:
 * - Fishburn (1967) — Simple Additive Weighting (SAW) original method
 * - Hwang & Yoon (1981) — Multi-Attribute Decision Making
 *
 * Langkah SAW:
 * 1. Bentuk matriks keputusan X (alternatif × kriteria)
 * 2. Normalisasi matriks R (benefit: Xij/max; cost: min/Xij)
 * 3. Hitung skor akhir: Vi = Σ (wj × rij)
 * 4. Ranking berdasarkan Vi tertinggi
 */
class SAWService
{
    /**
     * Jalankan SAW dan kembalikan ranking action plan.
     *
     * @param  AssessmentResult  $result  Hasil Forward Chaining
     * @return array  Array of ['action_plan' => ActionPlan, 'raw' => float, 'normalized' => float, 'final' => float, 'rank' => int]
     */
    public function rank(AssessmentResult $result): array
    {
        // 1. Ambil semua action plan aktif beserta nilai SAW per kriteria
        $actionPlans = ActionPlan::where('is_active', true)
            ->with(['criteriaScores.criteria'])
            ->get();

        if ($actionPlans->isEmpty()) {
            return [];
        }

        // 2. Ambil semua kriteria SAW terurut
        $criteria = SawCriteria::orderBy('order')->get();

        if ($criteria->isEmpty()) {
            return [];
        }

        // 3. Bangun matriks keputusan X[alternatif][kriteria]
        $matrix = $this->buildDecisionMatrix($actionPlans, $criteria);

        // 4. Normalisasi matriks
        $normalized = $this->normalizeMatrix($matrix, $criteria);

        // 5. Hitung skor akhir terbobot
        $scores = $this->calculateWeightedScores($normalized, $criteria);

        // 6. Urutkan dan beri peringkat
        arsort($scores); // sort descending

        $ranked = [];
        $rank   = 1;

        foreach ($scores as $apId => $finalScore) {
            $ap = $actionPlans->firstWhere('id', $apId);
            if (!$ap) continue;

            $ranked[] = [
                'action_plan'      => $ap,
                'saw_raw_score'    => round($matrix[$apId]['raw_sum'] ?? 0, 4),
                'saw_normalized'   => round(array_sum($normalized[$apId] ?? []) / max(1, count($criteria)), 4),
                'saw_final_score'  => round($finalScore, 4),
                'rank'             => $rank++,
            ];
        }

        return $ranked;
    }

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Bangun matriks keputusan dari nilai action plan per kriteria.
     *
     * @return array  $matrix[action_plan_id][criteria_id] = score
     */
    private function buildDecisionMatrix($actionPlans, $criteria): array
    {
        $matrix = [];

        foreach ($actionPlans as $ap) {
            $matrix[$ap->id] = ['raw_sum' => 0];
            $scoreMap = $ap->criteriaScores->keyBy('saw_criteria_id');

            foreach ($criteria as $c) {
                $score = $scoreMap[$c->id]->score ?? 3; // default 3 jika tidak ada
                $matrix[$ap->id][$c->id] = $score;
                $matrix[$ap->id]['raw_sum'] += $score;
            }
        }

        return $matrix;
    }

    /**
     * Normalisasi matriks menggunakan metode SAW standar.
     * - Benefit: rij = Xij / max(Xj)
     * - Cost:    rij = min(Xj) / Xij
     *
     * @return array  $normalized[action_plan_id][criteria_id] = normalized_value
     */
    private function normalizeMatrix(array $matrix, $criteria): array
    {
        $normalized = [];

        foreach ($criteria as $c) {
            // Kumpulkan semua nilai untuk kriteria ini
            $values = array_column(
                array_map(fn ($row) => ['v' => $row[$c->id] ?? 0], $matrix),
                'v'
            );

            $maxVal = max($values) ?: 1;
            $minVal = min($values) ?: 1;

            foreach ($matrix as $apId => $row) {
                if ($apId === 'raw_sum') continue;
                $val = $row[$c->id] ?? 0;

                $normalized[$apId][$c->id] = match ($c->type) {
                    'benefit' => $val / $maxVal,
                    'cost'    => $minVal / max($val, 0.001),
                    default   => $val / $maxVal,
                };
            }
        }

        return $normalized;
    }

    /**
     * Hitung skor akhir terbobot: Vi = Σ (wj × rij)
     *
     * @return array  $scores[action_plan_id] = final_score
     */
    private function calculateWeightedScores(array $normalized, $criteria): array
    {
        $scores = [];

        foreach ($normalized as $apId => $criteriaScores) {
            $totalScore = 0;
            foreach ($criteria as $c) {
                $rij = $criteriaScores[$c->id] ?? 0;
                $wj  = (float) $c->weight;
                $totalScore += $wj * $rij;
            }
            $scores[$apId] = $totalScore;
        }

        return $scores;
    }
}
