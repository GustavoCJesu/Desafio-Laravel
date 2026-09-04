<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendenceSession extends Model
{
    public function employee(): BelongsTo{
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function sessionTraining(): BelongsTo{
        return $this->belongsTo(SessionTraining::class, 'session_training_id');
    }
}
