<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActionPlan extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'category', 'source_reference',
        'how_to', 'duration_minutes', 'difficulty', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function criteriaScores(): HasMany
    {
        return $this->hasMany(ApCriteriaScore::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(RecommendationResult::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'cognitive'   => 'Restrukturisasi Kognitif (CBT)',
            'journaling'  => 'Refleksi Diri & Journaling',
            'behavioral'  => 'Perubahan Perilaku',
            'mindfulness' => 'Mindfulness & Relaksasi',
            'social'      => 'Dukungan Sosial',
            default       => $this->category,
        };
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy'   => 'Mudah',
            'medium' => 'Sedang',
            'hard'   => 'Sulit',
            default  => '-',
        };
    }
}
