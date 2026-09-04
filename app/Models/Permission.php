<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    public function rolepermission(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'permission_id');
    }
}
