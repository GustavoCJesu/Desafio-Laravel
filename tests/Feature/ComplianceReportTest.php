<?php

use App\Models\AttendanceSession;
use App\Models\Certificate;
use App\Models\Classes;
use App\Models\Employee;
use App\Models\Sector;
use App\Models\SessionTraining;

function complianceTraining(string $norm, string $status = 'Concluído', ?Employee $instructor = null): SessionTraining
{
    return SessionTraining::forceCreate([
        'instructor_id' => ($instructor ?? Employee::factory()->create())->id,
        'norm' => $norm,
        'title' => "Treinamento {$norm}",
        'description' => 'Descrição',
        'status' => $status,
        'class_amount' => 1,
        'class_min' => 8,
        'min_hours' => 8,
        'validity_months' => 12,
        'capacity' => 20,
        'location' => 'Sala 1',
    ]);
}

function complianceEnroll(SessionTraining $training, Employee $employee, float $attendedHours = 0): void
{
    $training->employees()->attach($employee);

    if ($attendedHours > 0) {
        $class = Classes::create([
            'session_training_id' => $training->id,
            'class_dt' => now()->subMonth(),
            'duration_hours' => $attendedHours,
            'status' => 'Concluído',
        ]);

        AttendanceSession::create([
            'employee_id' => $employee->id,
            'classes_id' => $class->id,
            'employee_attendance' => 'Compareceu',
        ]);
    }
}

function complianceCertificate(SessionTraining $training, Employee $employee, string $expiresAt): Certificate
{
    return Certificate::create([
        'instructor_id' => $training->instructor_id,
        'employee_id' => $employee->id,
        'session_training_id' => $training->id,
        'confirmed_at' => now()->subMonths(6),
        'expires_at' => $expiresAt,
        'status' => 'Válido',
    ]);
}

function complianceStatuses($response): array
{
    return $response->viewData('rows')->mapWithKeys(fn (array $row) => [$row['employee'] => $row['status']])->all();
}

test('the compliance report requires the permission to create reports', function () {
    $this->actingAs(userWithPermissions('ativo', 'reports.view'))
        ->get(route('report.compliance'))
        ->assertForbidden();

    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance'))
        ->assertOk()
        ->assertSee('Relatório de conformidade');
});

test('each employee is classified by the certificate situation for the norm', function () {
    $training = complianceTraining('NR-35');
    $scheduled = complianceTraining('NR-10', 'Agendado');

    $valid = Employee::factory()->create(['name' => 'Ana Valida']);
    $expiring = Employee::factory()->create(['name' => 'Bruno Avencer']);
    $expired = Employee::factory()->create(['name' => 'Carla Vencida']);
    $failed = Employee::factory()->create(['name' => 'Diego Reprovado']);
    $notIssued = Employee::factory()->create(['name' => 'Elisa Semcertificado']);
    $pending = Employee::factory()->create(['name' => 'Fabio Pendente']);

    foreach ([$valid, $expiring, $expired, $failed, $notIssued] as $employee) {
        complianceEnroll($training, $employee, $employee->is($failed) ? 2 : 8);
    }
    complianceEnroll($scheduled, $pending);

    complianceCertificate($training, $valid, now()->addYear()->toDateString());
    complianceCertificate($training, $expiring, now()->addDays(30)->toDateString());
    complianceCertificate($training, $expired, now()->subMonth()->toDateString());

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))->get(route('report.compliance'));

    expect(complianceStatuses($response))->toEqual([
        'Ana Valida' => 'Válido',
        'Bruno Avencer' => 'A vencer',
        'Carla Vencida' => 'Vencido',
        'Diego Reprovado' => 'Reprovado por carga horária',
        'Elisa Semcertificado' => 'Certificado não emitido',
        'Fabio Pendente' => 'Pendente',
    ]);
    expect($response->viewData('summary'))->toMatchArray(['requirements' => 6, 'compliant' => 2, 'rate' => 33]);
});

test('the most favourable certificate represents the employee in a norm', function () {
    $employee = Employee::factory()->create(['name' => 'Gabriel Renovado']);
    $old = complianceTraining('NR-35');
    $recent = complianceTraining('NR-35');

    complianceEnroll($old, $employee, 8);
    complianceEnroll($recent, $employee, 8);
    complianceCertificate($old, $employee, now()->subYear()->toDateString());
    complianceCertificate($recent, $employee, now()->addYear()->toDateString());

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))->get(route('report.compliance'));

    expect(complianceStatuses($response))->toBe(['Gabriel Renovado' => 'Válido']);
});

test('inactive employees and cancelled trainings are left out of the report', function () {
    $training = complianceTraining('NR-35');
    $cancelled = complianceTraining('NR-10', 'Cancelado');
    $inactive = Employee::factory()->create(['name' => 'Heitor Inativo', 'status' => 'Inativo']);
    $active = Employee::factory()->create(['name' => 'Iris Ativa']);

    complianceEnroll($training, $inactive, 8);
    complianceEnroll($cancelled, $active, 8);

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))->get(route('report.compliance'));

    expect($response->viewData('rows'))->toHaveCount(0);
});

test('the filters narrow the listing while the indicators keep the whole scope', function () {
    $training = complianceTraining('NR-35');
    $production = Sector::factory()->create();
    $office = Sector::factory()->create();
    $compliant = Employee::factory()->create(['name' => 'Joana Conforme', 'sector_id' => $production->id]);
    $irregular = Employee::factory()->create(['name' => 'Kleber Irregular', 'sector_id' => $production->id]);
    $other = Employee::factory()->create(['name' => 'Luiza Outrosetor', 'sector_id' => $office->id]);

    foreach ([$compliant, $irregular, $other] as $employee) {
        complianceEnroll($training, $employee, 8);
    }
    complianceCertificate($training, $compliant, now()->addYear()->toDateString());

    $user = userWithPermissions('ativo', 'reports.create');

    $bySector = $this->actingAs($user)->get(route('report.compliance', ['sector_id' => $production->id]));
    expect(array_keys(complianceStatuses($bySector)))->toEqualCanonicalizing(['Joana Conforme', 'Kleber Irregular']);

    $onlyPending = $this->actingAs($user)->get(route('report.compliance', ['only_pending' => 1]));
    expect($onlyPending->viewData('visibleRows')->pluck('employee')->all())->toEqualCanonicalizing(['Kleber Irregular', 'Luiza Outrosetor'])
        ->and($onlyPending->viewData('summary')['requirements'])->toBe(3);
});

test('an unknown sector is rejected by the filters', function () {
    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance', ['sector_id' => 999]))
        ->assertSessionHasErrors('sector_id');
});

test('exporting the compliance report requires the export permission', function () {
    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance.export'))
        ->assertForbidden();
});

test('the exported csv lists the rows and neutralizes spreadsheet formulas', function () {
    $training = complianceTraining('NR-35');
    $employee = Employee::factory()->create(['name' => '=HYPERLINK("http://x")']);
    complianceEnroll($training, $employee, 8);
    complianceCertificate($training, $employee, now()->addYear()->toDateString());

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.export'))->get(route('report.compliance.export'));

    $response->assertOk()->assertDownload();
    expect($response->headers->get('Content-Type'))->toContain('text/csv');

    $csv = $response->streamedContent();
    expect($csv)->toStartWith("\xEF\xBB\xBF".'Matrícula;Funcionário;Setor')
        ->and($csv)->toContain('"\'=HYPERLINK(""http://x"")";')
        ->and($csv)->toContain('NR-35;"Treinamento NR-35";Válido');
});
