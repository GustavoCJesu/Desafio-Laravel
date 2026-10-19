<?php

use App\Models\Permission;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserRoleSeeder;

test('the position permissions are seeded and granted only to the admin role', function () {
    $this->seed(UserRoleSeeder::class);
    $this->seed(PermissionsSeeder::class);
    $this->seed(RolePermissionSeeder::class);

    $slugs = ['positions.view', 'positions.create', 'positions.update', 'positions.delete'];
    expect(Permission::whereIn('slug', $slugs)->pluck('name', 'slug')->all())->toEqual([
        'positions.view' => 'Ver cargos',
        'positions.create' => 'Criar cargos',
        'positions.update' => 'Editar cargos',
        'positions.delete' => 'Apagar cargos',
    ]);

    $withPositionPermissions = UserRole::whereHas('rolePermissions', fn ($query) => $query->whereIn('slug', $slugs))->pluck('title')->all();
    expect($withPositionPermissions)->toBe(['admin']);
});

test('a position can only be created, updated and deleted with the matching permission', function (string $method, string $routeName, string $slug, array $data) {
    $role = UserRole::create(['title' => 'Alvo', 'status' => 'Ativo']);
    $parameters = $routeName === 'position.create' ? [] : [$role];

    $this->actingAs(userWithPermissions('ativo', 'epis.view'))
        ->{$method}(route($routeName, $parameters), $data)
        ->assertForbidden();

    $this->actingAs(userWithPermissions('ativo', $slug))
        ->{$method}(route($routeName, $parameters), $data)
        ->assertRedirect();
})->with([
    'create' => ['post', 'position.create', 'positions.create', ['title' => 'Novo cargo']],
    'update' => ['put', 'position.update', 'positions.update', ['title' => 'Cargo renomeado']],
    'delete' => ['delete', 'position.delete', 'positions.delete', []],
]);

test('creating, updating and deleting a position really change the database', function () {
    $user = userWithPermissions('ativo', 'positions.create', 'positions.update', 'positions.delete');
    $permission = Permission::create(['name' => 'Ver EPIs', 'slug' => 'epis.view']);

    $this->actingAs($user)->post(route('position.create'), ['title' => 'Auditor', 'permission_'.$permission->id => $permission->id]);
    $role = UserRole::where('title', 'Auditor')->firstOrFail();
    expect($role->rolePermissions()->pluck('slug')->all())->toBe(['epis.view']);

    $this->actingAs($user)->put(route('position.update', $role), ['title' => 'Auditor SST']);
    expect($role->fresh()->title)->toBe('Auditor SST')
        ->and($role->rolePermissions()->count())->toBe(0);

    $this->actingAs($user)->delete(route('position.delete', $role));
    expect(UserRole::find($role->id))->toBeNull();
});

test('the positions page only shows the actions the role is allowed to perform', function (array $slugs, array $visible, array $hidden) {
    $role = UserRole::create(['title' => 'Cargo exemplo', 'status' => 'Ativo']);

    $response = $this->actingAs(userWithPermissions('ativo', 'positions.view', ...$slugs))->get(route('position.index'));

    $response->assertOk()->assertSee('Cargo exemplo')
        ->assertSee($visible, false)
        ->assertDontSee($hidden, false);
})->with([
    'view only' => [[], [], ['Criar novo cargo', 'Novo cargo', 'editPositionModal-', 'title="Excluir"']],
    'create' => [['positions.create'], ['Criar novo cargo', 'Novo cargo'], ['editPositionModal-', 'title="Excluir"']],
    'update' => [['positions.update'], ['editPositionModal-'], ['Criar novo cargo', 'title="Excluir"']],
    'delete' => [['positions.delete'], ['title="Excluir"'], ['Criar novo cargo', 'editPositionModal-']],
]);

test('the professor role is seeded with permission to manage trainings but not positions', function () {
    $this->seed(UserRoleSeeder::class);
    $this->seed(PermissionsSeeder::class);
    $this->seed(RolePermissionSeeder::class);

    $slugs = UserRole::where('title', 'professor')->firstOrFail()->rolePermissions()->pluck('slug')->all();

    expect($slugs)->toContain('trainings.view', 'trainings.create', 'trainings.update', 'trainings.delete')
        ->not->toContain('positions.create', 'positions.update', 'positions.delete');
});

test('only roles with the view permission can open the positions page and see its menu link', function () {
    $this->actingAs(userWithPermissions('ativo', 'epis.view', 'positions.create'))
        ->get(route('position.index'))
        ->assertForbidden();

    $this->actingAs(userWithPermissions('ativo', 'epis.view'))
        ->get(route('epi.index'))
        ->assertDontSee(route('position.index'), false);

    $this->actingAs(userWithPermissions('ativo', 'epis.view', 'positions.view'))
        ->get(route('epi.index'))
        ->assertSee(route('position.index'), false);
});

test('each position card shows how many employees have that position', function () {
    $role = UserRole::create(['title' => 'Cargo com equipe', 'status' => 'Ativo']);
    User::factory()->count(3)->create(['user_role_id' => $role->id]);

    $this->actingAs(userWithPermissions('ativo', 'positions.view'))
        ->get(route('position.index'))
        ->assertOk()
        ->assertViewHas('positions', fn ($positions) => $positions->firstWhere('id', $role->id)->user_count === 3);
});
