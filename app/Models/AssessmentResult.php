<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentResult extends Model
{
    protected $fillable = [
        'assessment_id', 'qlc_level_id', 'total_score', 'base_level_score',
        'dominant_domain', 'domain_scores', 'fc_rules_fired',
    ];

    protected $casts = [
        'domain_scores'  => 'array',
        'fc_rules_fired' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function qlcLevel(): BelongsTo
    {
        return $this->belongsTo(QlcLevel::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(RecommendationResult::class)->orderBy('rank');
    }
}
