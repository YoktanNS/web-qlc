<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendationResult extends Model
{
    protected $fillable = [
        'assessment_result_id', 'action_plan_id',
        'saw_raw_score', 'saw_normalized_score', 'saw_final_score', 'rank',
    ];

    protected $casts = [
        'saw_raw_score'        => 'float',
        'saw_normalized_score' => 'float',
        'saw_final_score'      => 'float',
    ];

    public function assessmentResult(): BelongsTo
    {
        return $this->belongsTo(AssessmentResult::class);
    }

    public function actionPlan(): BelongsTo
    {
        return $this->belongsTo(ActionPlan::class);
    }
}
