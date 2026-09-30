<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingEmployee extends Model
{
    protected $fillable = [
        'session_training_id',
        'employee_id',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function sessionTraining(): BelongsTo
    {
        return $this->belongsTo(SessionTraining::class, 'session_training_id');
    }
}
