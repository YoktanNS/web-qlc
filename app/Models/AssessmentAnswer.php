<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentAnswer extends Model
{
    protected $fillable = [
        'assessment_id', 'symptom_id', 'likert_score', 'weighted_score',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class);
    }
}
