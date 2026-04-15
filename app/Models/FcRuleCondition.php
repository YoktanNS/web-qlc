<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FcRuleCondition extends Model
{
    protected $fillable = [
        'fc_rule_id', 'condition_type', 'symptom_id', 'operator', 'value',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(FcRule::class, 'fc_rule_id');
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class);
    }
}
