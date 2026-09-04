<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model {
    public function sector(): BelongsTo{
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function CompanyRole(): BelongsTo {
        return $this->belongsTo(CompanyRole::class, 'company_role_id');
    }

    public function session_training(): HasMany{
        return $this->hasMany(SessionTraining::class, 'instructor_id');
    }
}
