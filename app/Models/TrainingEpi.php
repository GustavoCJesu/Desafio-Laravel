<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingEpi extends Model
{
    public function epi(): BelongsTo{
        return $this->belongsTo(Epi::class, 'epi_id');
    }

    public function sessionTraining(): BelongsTo{
        return $this->belongsTo(SessionTraining::class, 'session_training_id');
    }
}
