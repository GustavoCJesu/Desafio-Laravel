<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionTraining extends Model
{
    public function instructor(): BelongsTo{
        return $this->belongsTo(Employee::class, 'instructor_id');
    }

    public function trainingEpi() : HasMany {
        return $this->hasMany(SessionTraining::class, 'training_epi_id');
    }
}
