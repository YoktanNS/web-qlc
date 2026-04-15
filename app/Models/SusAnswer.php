<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SusAnswer extends Model
{
    protected $fillable = ['sus_assessment_id', 'question_number', 'score'];

    public function susAssessment(): BelongsTo
    {
        return $this->belongsTo(SusAssessment::class);
    }
}
