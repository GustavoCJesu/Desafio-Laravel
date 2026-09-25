<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    protected $fillable = [
        'title',
        'status',
    ];

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'user_role_id');
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
