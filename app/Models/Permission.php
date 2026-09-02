<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    public function role_permission() : HasMany {
        return $this->hasMany(Role_Permission::class, 'permission_id');
    }
}
