<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Epi extends Model
{
    protected $fillable = ['name', 'category_id', 'ca', 'status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function trainingEpi(): HasMany
    {
        return $this->hasMany(SessionTraining::class, 'epi_id');
    }
}
