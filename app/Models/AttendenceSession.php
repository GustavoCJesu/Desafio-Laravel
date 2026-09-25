<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendenceSession extends Model
{
    protected $fillable = [
        'employee_id',
        'classes_id',
        'employee_attendence',
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
