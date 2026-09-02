<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    public function sector(): BelongsTo{
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function company_role(): BelongsTo {
        return $this->belongsTo(Company_role::class, 'company_role_id');
    }
}
