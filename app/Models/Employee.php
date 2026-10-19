<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    // Employee::create([
    //     'company_role_id' => 1,
    //     'sector_id' => 1,
    //     'registration' => '5223-2',
    //     'name' => 'Gustavo Conti Jesuino',
    //     'cpf' => '153.429.526-70',
    //     'hire_date' => '2026-05-05',
    //     'status' => 'Ativo',
    // ]);

    protected $fillable = [
        'name',
        'company_role_id',
        'sector_id',
        'cpf',
        'hire_date',
        'status',
        'registration',
    ];

    public const INSTRUCTOR_ROLE_TITLE = 'Professor';

    /**
     * Funcionários ativos com o cargo de professor, mais o instrutor atual (se informado)
     * para que uma aula antiga não perca o instrutor ao ser editada.
     */
    public function scopeInstructors(Builder $query, ?int $currentInstructorId = null): void
    {
        $query->where(function (Builder $query) use ($currentInstructorId) {
            $query->where('status', 'Ativo')
                ->whereHas('companyRole', fn (Builder $role) => $role->where('title', self::INSTRUCTOR_ROLE_TITLE));

            if ($currentInstructorId !== null) {
                $query->orWhere('id', $currentInstructorId);
            }
        });
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function companyRole(): BelongsTo
    {
        return $this->belongsTo(CompanyRole::class, 'company_role_id');
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(SessionTraining::class, 'training_employees', 'employee_id', 'session_training_id')->withTimestamps();
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'attendance_sessions', 'employee_id', 'classes_id')
            ->withPivot(['employee_attendance'])
            ->withTimestamps();
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function attendance_sessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function certificate(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public static function generateRegistration()
    {
        do {
            $number = str_pad(
                random_int(0, 9999),
                4,
                '0',
                STR_PAD_LEFT
            );

            $digit = random_int(0, 9);

            $registration = $number.'-'.$digit;

        } while (Employee::where('registration', $registration)->exists());

        return $registration;
    }
}
