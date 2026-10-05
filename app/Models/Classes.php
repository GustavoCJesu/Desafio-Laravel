<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    protected $fillable = [
        'session_training_id',
        'class_dt',
        'status',
    ];

    protected $casts = [
        'class_dt' => 'datetime',
    ];

    public function attendanceSession(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'attendance_sessions', 'classes_id', 'employee_id')
            ->withPivot(['employee_attendance', 'class_dt'])
            ->withTimestamps();
    }

    public function sessionTraining(): BelongsTo
    {
        return $this->belongsTo(SessionTraining::class);
    }
}
