<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function rolepermission(): BelongsToMany
    {
        return $this->BelongsToMany(UserRole::class, 'role_permissions', 'permission_id', 'user_role_id');
    }
}
