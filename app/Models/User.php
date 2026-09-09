<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array {
        return [
            'password' => 'hashed',
        ];
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function userRole(): BelongsTo {
        return $this->belongsTo(UserRole::class);
    }
}
