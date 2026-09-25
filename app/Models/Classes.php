<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    protected $fillable = [
        'session_training_id',
        'class_dt',
    ];

    protected $casts = [
        'class_dt' => 'date',
    ];

    public function attendanceSession(): HasMany
    {
        return $this->hasMany(AttendenceSession::class);
    }

    public function sessionTraining(): BelongsTo
    {
        return $this->belongsTo(SessionTraining::class);
    }
}
