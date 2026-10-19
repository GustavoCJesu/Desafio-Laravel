<?php

use App\Models\AttendanceSession;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Classes;
use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;

function trainingWithAttendance(array $hoursByEmployee, int $minHours = 8): array
{
    $instructor = Employee::factory()->create();
    $training = SessionTraining::forceCreate([
        'instructor_id' => $instructor->id,
        'norm' => 'NR-35',
        'title' => 'Trabalho em Altura',
        'description' => 'Descrição',
        'status' => 'Concluído',
        'class_amount' => 2,
        'class_min' => 8,
        'min_hours' => $minHours,
        'validity_months' => 12,
        'capacity' => 10,
        'location' => 'Sala 1',
    ]);

    $category = Category::forceCreate(['name' => 'Categoria']);
    $epi = Epi::forceCreate(['name' => 'Capacete', 'category_id' => $category->id, 'ca' => '12345', 'status' => 'Ativo']);
    $training->epis()->attach($epi);

    $morning = Classes::create([
        'session_training_id' => $training->id,
        'duration_hours' => 4,
        'status' => 'Concluído']);

    $afternoon = Classes::create([
        'session_training_id' => $training->id,
        'duration_hours' => 4,
        'status' => 'Concluído']);

    $employees = [];
    foreach ($hoursByEmployee as $name => $attendedClasses) {
        $employee = Employee::factory()->create(['name' => $name]);
        $training->employees()->attach($employee);

        foreach ([$morning, $afternoon] as $index => $class) {
            AttendanceSession::create([
                'employee_id' => $employee->id,
                'classes_id' => $class->id,
                'employee_attendance' => $index < $attendedClasses ? 'Compareceu' : 'Faltou',
                'class_dt' => $class->class_dt,
            ]);
        }

        $employees[$name] = $employee;
    }

    return [$training, $employees, $epi];
}

test('only employees who reached the minimum hours receive a certificate', function () {
    [$training, $employees, $epi] = trainingWithAttendance(['Aprovado' => 2, 'Reprovado' => 1]);

    $this->actingAs(userWithPermissions('ativo', 'certificates.allow'))
        ->post(route('certificate.store', $training))
        ->assertSessionHas('Success');

    expect(Certificate::count())->toBe(1);

    $certificate = Certificate::first();
    expect($certificate->employee_id)->toBe($employees['Aprovado']->id)
        ->and($certificate->session_training_id)->toBe($training->id)
        ->and($certificate->instructor_id)->toBe($training->instructor_id)
        ->and($certificate->expires_at->toDateString())->toBe(now()->addMonths(12)->toDateString())
        ->and($certificate->epis->pluck('id')->all())->toBe([$epi->id]);
});

test('no certificate is issued when nobody reached the minimum hours', function () {
    [$training] = trainingWithAttendance(['Reprovado' => 1]);

    $this->actingAs(userWithPermissions('ativo', 'certificates.allow'))
        ->post(route('certificate.store', $training))
        ->assertSessionHas('Error');

    expect(Certificate::count())->toBe(0);
});

test('issuing twice does not duplicate certificates', function () {
    [$training] = trainingWithAttendance(['Aprovado' => 2]);
    $user = userWithPermissions('ativo', 'certificates.allow');

    $this->actingAs($user)->post(route('certificate.store', $training));
    $this->actingAs($user)->post(route('certificate.store', $training))->assertSessionHas('Error');

    expect(Certificate::count())->toBe(1);
});
