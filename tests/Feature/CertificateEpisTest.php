<?php

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;
use App\Models\User;

function issuedCertificateWithEpis(array $epiNames): Certificate
{
    $instructor = Employee::factory()->create();
    $training = SessionTraining::forceCreate([
        'instructor_id' => $instructor->id,
        'norm' => 'NR-35',
        'title' => 'Trabalho em Altura',
        'description' => 'Descrição',
        'status' => 'Concluído',
        'class_amount' => 1,
        'class_min' => 8,
        'min_hours' => 8,
        'validity_months' => 12,
        'capacity' => 10,
        'location' => 'Sala 1',
    ]);

    $certificate = Certificate::create([
        'instructor_id' => $instructor->id,
        'employee_id' => Employee::factory()->create()->id,
        'session_training_id' => $training->id,
        'confirmed_at' => now(),
        'expires_at' => now()->addYear(),
        'status' => 'Válido',
    ]);

    $category = Category::forceCreate(['name' => 'Categoria']);

    foreach ($epiNames as $name) {
        $epi = Epi::forceCreate(['name' => $name, 'category_id' => $category->id, 'ca' => fake()->unique()->numerify('#####'), 'status' => 'Ativo']);
        $certificate->epis()->attach($epi);
    }

    return $certificate;
}

test('the certificates page lists the epis covered by each certificate', function () {
    issuedCertificateWithEpis(['Capacete', 'Cinto']);

    $response = $this->actingAs(User::factory()->create())->get(route('certificate.index'));

    $response->assertOk()->assertSee('EPIs abordados no treinamento');
    expect($response->getContent())->toContain('Capacete', 'Cinto');
});

test('a certificate without linked epis is listed with an empty epi list', function () {
    issuedCertificateWithEpis([]);

    $this->actingAs(User::factory()->create())
        ->get(route('certificate.index'))
        ->assertOk()
        ->assertSee('"epis":[]', false);
});
