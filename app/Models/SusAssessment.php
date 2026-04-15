<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SusAssessment extends Model
{
    protected $fillable = [
        'assessment_id', 'user_id', 'guest_token',
        'sus_score', 'sus_grade', 'sus_adjective', 'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'sus_score'    => 'float',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SusAnswer::class)->orderBy('question_number');
    }

    /**
     * Hitung skor SUS berdasarkan 10 jawaban standar.
     * Rumus: ((S_ganjil - 1) + (5 - S_genap)) × 2.5
     */
    public function calculateScore(): float
    {
        $answers = $this->answers()->pluck('score', 'question_number');
        $total = 0;
        for ($i = 1; $i <= 10; $i++) {
            $score = $answers[$i] ?? 3;
            if ($i % 2 !== 0) {
                // Pertanyaan ganjil (positif): score - 1
                $total += ($score - 1);
            } else {
                // Pertanyaan genap (negatif): 5 - score
                $total += (5 - $score);
            }
        }
        return $total * 2.5;
    }

    /**
     * Tentukan grade SUS berdasarkan skor.
     */
    public static function getGrade(float $score): array
    {
        return match (true) {
            $score >= 90.9 => ['grade' => 'A+', 'adjective' => 'Best Imaginable'],
            $score >= 84.1 => ['grade' => 'A',  'adjective' => 'Excellent'],
            $score >= 80.8 => ['grade' => 'A-', 'adjective' => 'Excellent'],
            $score >= 77.2 => ['grade' => 'B+', 'adjective' => 'Good'],
            $score >= 72.6 => ['grade' => 'B',  'adjective' => 'Good'],
            $score >= 71.1 => ['grade' => 'B-', 'adjective' => 'Good'],
            $score >= 65.0 => ['grade' => 'C+', 'adjective' => 'Okay'],
            $score >= 62.7 => ['grade' => 'C',  'adjective' => 'Okay'],
            $score >= 51.7 => ['grade' => 'C-', 'adjective' => 'Okay'],
            $score >= 51.6 => ['grade' => 'D',  'adjective' => 'Poor'],
            default        => ['grade' => 'F',  'adjective' => 'Awful / Worst Imaginable'],
        };
    }
}
