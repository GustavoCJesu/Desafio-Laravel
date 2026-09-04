<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model {
    public function userRole(): BelongsTo{
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function permission() : BelongsTo {

        return $this->belongsTo(Permission::class, 'permission_id');

    }
}
