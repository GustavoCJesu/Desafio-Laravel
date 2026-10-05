<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSession extends Model
{
    protected $fillable = [
        'employee_id',
        'classes_id',
        'employee_attendance',
        'class_dt',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}
