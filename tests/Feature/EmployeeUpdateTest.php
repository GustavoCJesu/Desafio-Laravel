<?php

use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Sector;

test('updating an employee without changing the cpf succeeds', function () {
    $sector = Sector::factory()->create();
    $role = CompanyRole::factory()->create();
    $employee = Employee::factory()->create([
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
    $existing = Employee::factory()->create([
        'sector_id' => $sector->id,
        'company_role_id' => $role->id,
        'cpf' => '111.111.111-11',
    ]);
    $employee = Employee::factory()->create([
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
