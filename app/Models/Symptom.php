<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Symptom extends Model
{
    protected $fillable = [
        'symptom_category_id', 'code', 'statement', 'reference',
        'is_critical', 'order', 'is_active',
    ];

    protected $casts = [
        'is_critical' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SymptomCategory::class, 'symptom_category_id');
    }

    public function assessmentAnswers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class);
    }

    public function fcRuleConditions(): HasMany
    {
        return $this->hasMany(FcRuleCondition::class);
    }
}
