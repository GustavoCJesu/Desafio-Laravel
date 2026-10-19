<?php

use App\Models\Certificate;
use App\Models\SessionTraining;
use Illuminate\Console\Scheduling\Schedule;

function certificateExpiringOn(string $date, string $status = 'Válido'): Certificate
{
    static $training = null;
    $training = SessionTraining::find($training?->id) ?? SessionTraining::forceCreate([
        'instructor_id' => createEmployee()->id,
        'norm' => 'NR-35',
        'title' => 'Trabalho em Altura',
        'description' => 'Descrição',
        'status' => 'Concluído',
        'class_amount' => 1,
        'class_min' => 8,
        'min_hours' => 8,
        'validity_months' => 12,
        'capacity' => 20,
        'location' => 'Sala 1',
    ]);

    return Certificate::create([
        'instructor_id' => $training->instructor_id,
        'employee_id' => createEmployee()->id,
        'session_training_id' => $training->id,
        'confirmed_at' => now()->subYear(),
        'expires_at' => $date,
        'status' => $status,
    ]);
}

test('the command stores the situation of each certificate by its expiry date', function () {
    $expiredYesterday = certificateExpiringOn(today()->subDay()->toDateString());
    $expiresToday = certificateExpiringOn(today()->toDateString());
    $expiresInLimit = certificateExpiringOn(today()->addDays(60)->toDateString());
    $expiresAfterLimit = certificateExpiringOn(today()->addDays(61)->toDateString(), 'Vencido');

    $this->artisan('certificates:update-status')->assertSuccessful();

    expect($expiredYesterday->fresh()->status)->toBe('Vencido')
        ->and($expiresToday->fresh()->status)->toBe('A vencer')
        ->and($expiresInLimit->fresh()->status)->toBe('A vencer')
        ->and($expiresAfterLimit->fresh()->status)->toBe('Válido');
});

test('the stored situation agrees with the situation computed by the model', function () {
    $certificates = collect([-400, -1, 0, 1, 30, 60, 61, 400])
        ->map(fn (int $days) => certificateExpiringOn(today()->addDays($days)->toDateString(), 'Válido'));

    $this->artisan('certificates:update-status');

    foreach ($certificates as $certificate) {
        expect($certificate->fresh()->status)->toBe($certificate->fresh()->currentStatus());
    }
});

test('running the command again changes nothing', function () {
    certificateExpiringOn(today()->subMonth()->toDateString());

    $this->artisan('certificates:update-status');
    $updatedAt = Certificate::first()->updated_at;

    $this->travel(5)->minutes();
    $this->artisan('certificates:update-status');

    expect(Certificate::first()->updated_at->equalTo($updatedAt))->toBeTrue();
});

test('the command is scheduled to run every day', function () {
    $events = collect(app(Schedule::class)->events())
        ->filter(fn ($event) => str_contains($event->command, 'certificates:update-status'));

    expect($events)->toHaveCount(1)
        ->and($events->first()->expression)->toBe('5 0 * * *');
});
