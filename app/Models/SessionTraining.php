<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionTraining extends Model
{
    protected $fillable = [
        'instructor_id',
        'norm',
        'title',
        'description',
        'scheduled',
        'status',
        'class_amount',
        'class_min',
        'capacity',
        'location',
        'validity_dt',
    ];

    protected $casts = [
        'scheduled' => 'datetime',
        'validity_dt' => 'date',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'instructor_id');
    }

    public function epis(): BelongsToMany
    {
        return $this->belongsToMany(Epi::class, 'training_epis', 'session_training_id', 'epi_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'training_employees', 'session_training_id', 'employee_id')->withTimestamps();
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }
}
