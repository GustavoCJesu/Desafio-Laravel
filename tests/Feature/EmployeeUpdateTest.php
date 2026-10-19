<?php

use App\Models\CompanyRole;
use App\Models\Sector;

test('updating an employee without changing the cpf succeeds', function () {
    $sector = Sector::factory()->create();
    $role = CompanyRole::factory()->create();
    $employee = createEmployee([
        'sector_id' => $sector->id,
        'company_role_id' => $role->id,
        'cpf' => '111.111.111-11',
    ]);

    $response = $this->actingAs(userWithPermissions('ativo', 'employees.update'))
        ->put(route('employee.update', $employee->id), [
            'name' => $employee->name,
            'cpf' => $employee->cpf,
            'registration' => $employee->registration,
            'sector_id' => $sector->id,
            'company_role_id' => $role->id,
            'hire_date' => $employee->hire_date,
        ]);

    $response->assertRedirect(route('employees.viewUpdate', $employee->id));
    $response->assertSessionHas('Success');
    $response->assertSessionDoesntHaveErrors();
});

test('updating an employee with another employees cpf fails validation', function () {
    $sector = Sector::factory()->create();
    $role = CompanyRole::factory()->create();
    $existing = createEmployee([
        'sector_id' => $sector->id,
        'company_role_id' => $role->id,
        'cpf' => '111.111.111-11',
    ]);
    $employee = createEmployee([
        'sector_id' => $sector->id,
        'company_role_id' => $role->id,
        'cpf' => '222.222.222-22',
    ]);

    $response = $this->actingAs(userWithPermissions('ativo', 'employees.update'))
        ->put(route('employee.update', $employee->id), [
            'name' => $employee->name,
            'cpf' => $existing->cpf,
            'registration' => $employee->registration,
            'sector_id' => $sector->id,
            'company_role_id' => $role->id,
            'hire_date' => $employee->hire_date,
        ]);

    $response->assertSessionHasErrors('cpf');
    expect($employee->fresh()->cpf)->toBe('222.222.222-22');
});

test('toggling an employee from the table flips the status', function () {
    $employee = createEmployee(['status' => 'Ativo']);
    $user = userWithPermissions('ativo', 'employees.update');

    $this->actingAs($user)->post(route('employees.change'), ['selected_employees' => $employee->id])->assertRedirect();
    expect($employee->fresh()->status)->toBe('Inativo');

    $this->actingAs($user)->post(route('employees.change'), ['selected_employees' => $employee->id]);
    expect($employee->fresh()->status)->toBe('Ativo');
});

test('the employees table shows the toggle button only to roles that can update employees', function () {
    createEmployee(['status' => 'Ativo']);
    createEmployee(['status' => 'Inativo']);

    $viewer = $this->actingAs(userWithPermissions('ativo', 'employees.view'))->get(route('employees.index'));
    $viewer->assertOk()->assertDontSee('title="Desativar"', false)->assertDontSee('title="Ativar"', false);

    $editor = $this->actingAs(userWithPermissions('ativo', 'employees.view', 'employees.update'))->get(route('employees.index'));
    $editor->assertOk()->assertSee('title="Desativar"', false)->assertSee('title="Ativar"', false);
});
