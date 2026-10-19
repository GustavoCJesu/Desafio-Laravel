<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certificate extends Model
{
    public const STATUS_VALID = 'Válido';

    public const STATUS_EXPIRING = 'A vencer';

    public const STATUS_EXPIRED = 'Vencido';

    public const EXPIRING_DAYS = 60;

    protected $fillable = [
        'instructor_id',
        'employee_id',
        'session_training_id',
        'confirmed_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'confirmed_at' => 'date',
        'expires_at' => 'date',
    ];

    public function sessionTraining(): BelongsTo
    {
        return $this->belongsTo(SessionTraining::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'instructor_id');
    }

    public function epis(): BelongsToMany
    {
        return $this->belongsToMany(Epi::class, 'certificate_epis', 'certificate_id', 'epi_id')->withTimestamps();
    }

    /**
     * Situação pela data de validade. O certificado vale até o fim do dia de vencimento:
     * Vencido (data anterior a hoje), A vencer (hoje até EXPIRING_DAYS dias) ou Válido.
     */
    public static function statusForDate(CarbonInterface $expiresAt): string
    {
        if ($expiresAt->lt(today())) {
            return self::STATUS_EXPIRED;
        }

        return today()->diffInDays($expiresAt) <= self::EXPIRING_DAYS ? self::STATUS_EXPIRING : self::STATUS_VALID;
    }

    public function currentStatus(): string
    {
        return self::statusForDate($this->expires_at);
    }
}
