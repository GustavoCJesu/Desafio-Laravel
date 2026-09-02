<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User_Role extends Model
{
    public function role__permissions(): HasMany{
        return $this->hasMany(Role_Permission::class, 'user_role_id');
    }
}
