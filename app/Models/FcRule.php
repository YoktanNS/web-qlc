<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FcRule extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'priority',
        'target_level_id', 'action_type', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function targetLevel(): BelongsTo
    {
        return $this->belongsTo(QlcLevel::class, 'target_level_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(FcRuleCondition::class);
    }
}
