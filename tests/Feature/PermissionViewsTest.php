<?php

use App\Models\Category;
use App\Models\Epi;
use App\Models\Permission;
use Database\Seeders\PermissionsSeeder;

test('the epi page only shows the actions the role is allowed to perform', function (array $slugs, array $visible, array $hidden) {
    $category = Category::forceCreate(['name' => 'Cabeça']);
    $epi = Epi::create(['name' => 'Capacete', 'category_id' => $category->id, 'ca' => '12345', 'status' => 'Ativo']);

    $response = $this->actingAs(userWithPermissions('ativo', ...$slugs))->get(route('epi.index'));

    $response->assertOk()
        ->assertSee($visible, false)
        ->assertDontSee($hidden, false);
})->with([
    'view only' => [['epis.view'], ['Capacete'], ['Adicionar EPI', 'title="Editar"', 'title="Excluir"']],
    'create' => [['epis.view', 'epis.create'], ['Adicionar EPI'], ['title="Editar"', 'title="Excluir"']],
    'update' => [['epis.view', 'epis.update'], ['title="Editar"', 'title="Desativar"'], ['Adicionar EPI', 'title="Excluir"']],
    'delete' => [['epis.view', 'epis.delete'], ['title="Excluir"'], ['Adicionar EPI', 'title="Editar"']],
]);

test('the sidebar hides the links of modules the role cannot view', function () {
    $response = $this->actingAs(userWithPermissions('ativo', 'epis.view'))->get(route('epi.index'));

    $response->assertSee(route('epi.index'))
        ->assertSee(route('dashboard'))
        ->assertDontSee(route('report.index'))
        ->assertDontSee(route('employees.index'))
        ->assertDontSee(route('training.index'));
});

test('the sidebar shows every module link to a role with all view permissions', function () {
    $response = $this->actingAs(userWithPermissions('ativo', 'epis.view', 'reports.view', 'employees.view', 'trainings.view'))
        ->get(route('epi.index'));

    $response->assertSee(route('report.index'))
        ->assertSee(route('employees.index'))
        ->assertSee(route('training.index'));
});

test('the pages with permission checks render for a role that has every permission', function (string $routeName) {
    $this->seed(PermissionsSeeder::class);
    $slugs = Permission::pluck('slug')->all();

    $this->actingAs(userWithPermissions('ativo', ...$slugs))
        ->get(route($routeName))
        ->assertOk();
})->with(['dashboard', 'employees.index', 'training.index', 'epi.index', 'report.index']);
