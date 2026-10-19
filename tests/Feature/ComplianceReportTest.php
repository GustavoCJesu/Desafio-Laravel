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
        'instructor_id' => ($instructor ?? createEmployee())->id,
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

    $valid = createEmployee(['name' => 'Ana Valida']);
    $expiring = createEmployee(['name' => 'Bruno Avencer']);
    $expired = createEmployee(['name' => 'Carla Vencida']);
    $failed = createEmployee(['name' => 'Diego Reprovado']);
    $notIssued = createEmployee(['name' => 'Elisa Semcertificado']);
    $pending = createEmployee(['name' => 'Fabio Pendente']);

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
    $employee = createEmployee(['name' => 'Gabriel Renovado']);
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
    $inactive = createEmployee(['name' => 'Heitor Inativo', 'status' => 'Inativo']);
    $active = createEmployee(['name' => 'Iris Ativa']);

    complianceEnroll($training, $inactive, 8);
    complianceEnroll($cancelled, $active, 8);

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))->get(route('report.compliance'));

    expect($response->viewData('rows'))->toHaveCount(0);
});

test('the filters narrow the listing while the indicators keep the whole scope', function () {
    $training = complianceTraining('NR-35');
    $production = Sector::factory()->create();
    $office = Sector::factory()->create();
    $compliant = createEmployee(['name' => 'Joana Conforme', 'sector_id' => $production->id]);
    $irregular = createEmployee(['name' => 'Kleber Irregular', 'sector_id' => $production->id]);
    $other = createEmployee(['name' => 'Luiza Outrosetor', 'sector_id' => $office->id]);

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
    $employee = createEmployee(['name' => '=HYPERLINK("http://x")']);
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

test('the filter form keeps the chosen options and offers a way to clear them', function () {
    $sector = Sector::factory()->create();
    complianceTraining('NR-35');

    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance', ['sector_id' => $sector->id, 'norm' => 'NR-35', 'only_pending' => 1]))
        ->assertOk()
        ->assertSee('<option value="'.$sector->id.'" selected>', false)
        ->assertSee('<option value="NR-35" selected>', false)
        ->assertSee('title="Limpar filtros"', false);
});

test('the coverage counts every active employee, including those never convoked', function () {
    $training = complianceTraining('NR-35');
    $sector = Sector::factory()->create();

    $covered = createEmployee(['sector_id' => $sector->id]);
    $convoked = createEmployee(['sector_id' => $sector->id]);
    createEmployee(['sector_id' => $sector->id]);
    createEmployee(['sector_id' => $sector->id]);
    createEmployee(['sector_id' => $sector->id, 'status' => 'Inativo']);
    createEmployee();

    complianceEnroll($training, $covered, 8);
    complianceEnroll($training, $convoked, 8);
    complianceCertificate($training, $covered, now()->addYear()->toDateString());

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance', ['sector_id' => $sector->id]));

    expect($response->viewData('coverage'))->toMatchArray([
        'employees' => 4,
        'covered' => 1,
        'convoked_without_certificate' => 1,
        'untrained' => 2,
        'rate' => 25,
    ]);
    expect($response->viewData('coverageBySector')->all())->toBe([
        ['name' => $sector->name, 'employees' => 4, 'covered' => 1, 'rate' => 25],
    ]);
});

test('an expired certificate does not count as coverage and a certificate valid until today does', function () {
    $training = complianceTraining('NR-35');
    $expired = createEmployee();
    $expiresToday = createEmployee();

    complianceEnroll($training, $expired, 8);
    complianceEnroll($training, $expiresToday, 8);
    complianceCertificate($training, $expired, now()->subDay()->toDateString());
    complianceCertificate($training, $expiresToday, today()->toDateString());

    $response = $this->actingAs(userWithPermissions('ativo', 'reports.create'))->get(route('report.compliance'));

    expect($response->viewData('coverage'))->toMatchArray(['employees' => 3, 'covered' => 1, 'convoked_without_certificate' => 1, 'untrained' => 1]);
});

test('the norm filter limits the coverage to certificates of that norm', function () {
    $height = complianceTraining('NR-35');
    $electricity = complianceTraining('NR-10');
    $employee = createEmployee();

    complianceEnroll($height, $employee, 8);
    complianceCertificate($height, $employee, now()->addYear()->toDateString());

    $user = userWithPermissions('ativo', 'reports.create');

    expect($this->actingAs($user)->get(route('report.compliance', ['norm' => 'NR-35']))->viewData('coverage')['covered'])->toBe(1)
        ->and($this->actingAs($user)->get(route('report.compliance', ['norm' => 'NR-10']))->viewData('coverage'))
        ->toMatchArray(['employees' => 3, 'covered' => 0, 'untrained' => 3]);
});

test('the report page shows the workforce coverage', function () {
    createEmployee();

    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance'))
        ->assertOk()
        ->assertSee('Cobertura da força de trabalho')
        ->assertSee('Sem treinamento registrado')
        ->assertSee('Cobertura por setor')
        ->assertSee('lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]', false);
});

test('the back button falls back to a page the role can open', function () {
    $this->actingAs(userWithPermissions('ativo', 'reports.create', 'employees.view'))
        ->get(route('report.compliance'))
        ->assertSee('id="report-back" href="'.route('employees.index').'"', false);

    $this->actingAs(userWithPermissions('ativo', 'reports.create'))
        ->get(route('report.compliance'))
        ->assertSee('id="report-back" href="'.route('certificate.index').'"', false);
});
