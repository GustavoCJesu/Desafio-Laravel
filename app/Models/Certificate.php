<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certificate extends Model
{
    protected $fillable = [
        'instructor_id',
        'employee_id',
        'session_training_id',
        'confirmed_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'confirmed_at' => 'date',
        'expires_at' => 'date',
    ];

    public function sessionTraining(): BelongsTo
    {
        return $this->belongsTo(SessionTraining::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'instructor_id');
    }

    public function epis(): BelongsToMany
    {
        return $this->belongsToMany(Epi::class, 'certificate_epis', 'certificate_id', 'epi_id')->withTimestamps();
    }
}
