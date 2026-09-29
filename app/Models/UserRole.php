<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    protected $fillable = [
        'title',
        'status',
    ];

    public function rolePermissions(): BelongsToMany
    {
        return $this->BelongsToMany(Permission::class, 'role_permissions', 'user_role_id', 'permission_id');
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
