<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SawCriteria extends Model
{
    protected $table = 'saw_criteria';

    protected $fillable = ['code', 'name', 'description', 'weight', 'type', 'order'];

    public function apScores(): HasMany
    {
        return $this->hasMany(ApCriteriaScore::class, 'saw_criteria_id');
    }
}
