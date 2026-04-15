<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SymptomCategory extends Model
{
    protected $fillable = ['code', 'name', 'description', 'icon', 'order'];

    public function symptoms(): HasMany
    {
        return $this->hasMany(Symptom::class)->orderBy('order');
    }
}
