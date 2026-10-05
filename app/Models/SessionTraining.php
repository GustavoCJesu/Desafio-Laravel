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
        'status',
        'class_amount',
        'class_min',
        'min_hours',
        'capacity',
        'location',
        'validity_dt',
    ];

    protected $casts = [
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

    /**
     * Marks the training as concluded once every planned class is concluded,
     * and reopens it if that is no longer true. Cancelled trainings are kept.
     */
    public function syncStatusWithClasses(): void
    {
        if ($this->status === 'Cancelado') {
            return;
        }

        $totalClasses = $this->classes()->count();
        $pendingClasses = $this->classes()->where('status', '!=', 'Concluído')->count();
        $isConcluded = $totalClasses > 0 && $totalClasses >= $this->class_amount && $pendingClasses === 0;

        $this->update(['status' => $isConcluded ? 'Concluído' : 'Agendado']);
    }
}
