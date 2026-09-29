<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    public function rolepermission(): BelongsToMany
    {
        return $this->BelongsToMany(UserRole::class, 'RolePermission', 'permission_id', 'user_role_id');
    }
}
