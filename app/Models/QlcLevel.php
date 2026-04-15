<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QlcLevel extends Model
{
    protected $fillable = [
        'code', 'name', 'score_min', 'score_max',
        'description', 'advice', 'color_class', 'icon', 'allow_action_plan',
    ];

    protected $casts = [
        'allow_action_plan' => 'boolean',
    ];

    public function assessmentResults(): HasMany
    {
        return $this->hasMany(AssessmentResult::class);
    }

    public function fcRules(): HasMany
    {
        return $this->hasMany(FcRule::class, 'target_level_id');
    }
}
