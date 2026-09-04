<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateEpi extends Model
{
    public function certificate(): BelongsTo {
        return $this->belongsTo(Certificate::class);
    }

    public function epi(): BelongsTo {
        return $this->belongsTo(Epi::class);
    }
}
