<?php

use App\Models\Classes;
use App\Models\Employee;
use App\Models\SessionTraining;
use App\Models\User;

function createTrainings(int $amount): void
{
    foreach (range(1, $amount) as $number) {
        SessionTraining::forceCreate([
            'instructor_id' => Employee::factory()->create()->id,
            'norm' => 'NR-35',
            'title' => "Aula {$number}",
            'capacity' => 10,
            'location' => 'Sala 1',
        ]);
    }
}

test('the trainings page lists six trainings per page', function () {
    createTrainings(8);
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('training.index'))
        ->assertOk()
        ->assertViewHas('trainings', fn ($trainings) => $trainings->count() === 6 && $trainings->lastPage() === 2)
        ->assertSee('Página');

    $this->actingAs($user)->get(route('training.index', ['page' => 2]))
        ->assertViewHas('trainings', fn ($trainings) => $trainings->count() === 2);
});

test('deleting a training removes it together with its classes', function () {
    createTrainings(1);
    $training = SessionTraining::first();
    $training->classes()->create(['class_dt' => '2026-10-10 14:30:00']);

    $this->actingAs(User::factory()->create())
        ->delete(route('training.delete', $training))
        ->assertSessionHas('Success');

    expect(SessionTraining::count())->toBe(0);
    expect(Classes::count())->toBe(0);
});

test('completing every planned class concludes the training', function () {
    createTrainings(1);
    $training = SessionTraining::first();
    $training->update(['class_amount' => 2, 'status' => 'Agendado']);
    $first = $training->classes()->create(['class_dt' => '2026-10-10 08:00:00']);
    $second = $training->classes()->create(['class_dt' => '2026-10-11 08:00:00']);
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('training.completeclass', [$training, $first]));
    expect($training->fresh()->status)->toBe('Agendado');

    $this->actingAs($user)->post(route('training.completeclass', [$training, $second]));
    expect($training->fresh()->status)->toBe('Concluído');
});

test('creating a training rejects a minimum workload above the total workload', function () {
    $employee = Employee::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('training.create'), [
            'norm' => 'NR-35',
            'title' => 'Trabalho em Altura',
            'description' => 'Descrição',
            'instructor_id' => $employee->id,
            'status' => 'Agendado',
            'validity_dt' => '2028-10-02',
            'class_min' => 8,
            'min_hours' => 12,
            'class_amount' => 1,
            'capacity' => 20,
        ])
        ->assertSessionHasErrors('min_hours');

    expect(SessionTraining::count())->toBe(0);
});
