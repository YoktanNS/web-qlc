<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApCriteriaScore extends Model
{
    protected $fillable = ['action_plan_id', 'saw_criteria_id', 'score'];

    public function actionPlan(): BelongsTo
    {
        return $this->belongsTo(ActionPlan::class);
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(SawCriteria::class, 'saw_criteria_id');
    }
}
