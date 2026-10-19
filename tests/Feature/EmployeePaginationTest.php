<?php

use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Sector;

function employees(int $amount, array $attributes = []): void
{
    Employee::factory()->count($amount)->create(array_merge([
        'company_role_id' => CompanyRole::factory()->create()->id,
        'sector_id' => Sector::factory()->create()->id,
        'status' => 'Ativo',
    ], $attributes));
}

test('the employees page lists ten employees per page', function () {
    employees(13);
    $user = userWithPermissions('ativo', 'employees.view');

    $first = $this->actingAs($user)->get(route('employees.index'));
    $first->assertOk();
    expect($first->viewData('employees'))->toHaveCount(10)
        ->and($first->viewData('employees')->total())->toBe(13);

    $second = $this->actingAs($user)->get(route('employees.index', ['page' => 2]));
    expect($second->viewData('employees'))->toHaveCount(3);
    $second->assertSee('Página', false)->assertSee('13 funcionários');
});

test('the counters describe the whole filtered list, not only the current page', function () {
    $sector = Sector::factory()->create();
    employees(8, ['sector_id' => $sector->id, 'status' => 'Ativo']);
    employees(5, ['sector_id' => $sector->id, 'status' => 'Inativo']);
    employees(4);

    $response = $this->actingAs(userWithPermissions('ativo', 'employees.view'))
        ->get(route('employees.index', ['sector' => $sector->id]));

    expect($response->viewData('employees')->total())->toBe(13)
        ->and($response->viewData('statusCounts')->all())->toEqual(['Ativo' => 8, 'Inativo' => 5]);
});

test('the page links keep the active filters', function () {
    $sector = Sector::factory()->create();
    employees(12, ['sector_id' => $sector->id]);

    $this->actingAs(userWithPermissions('ativo', 'employees.view'))
        ->get(route('employees.index', ['sector' => $sector->id, 'status' => 'Ativo']))
        ->assertOk()
        ->assertSee('sector='.$sector->id, false)
        ->assertSee('status=Ativo', false);
});

test('listing employees does not run extra queries per row', function () {
    employees(10);
    $user = userWithPermissions('ativo', 'employees.view');

    $this->actingAs($user)->get(route('employees.index'));
    DB::enableQueryLog();
    $this->get(route('employees.index'))->assertOk();
    $withTenRows = count(DB::getQueryLog());
    DB::flushQueryLog();

    Employee::query()->delete();
    employees(2);
    DB::flushQueryLog();
    $this->get(route('employees.index'))->assertOk();

    expect($withTenRows)->toBe(count(DB::getQueryLog()));
});
