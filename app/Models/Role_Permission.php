<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role_Permission extends Model
{
    public function user_role(): BelongsTo{
        return $this->belongsTo(User_Role::class, 'user_role_id');
    }

    public function permission() : BelongsTo {

    return $this->belongsTo(Permission::class, 'permission_id');

    }
}
