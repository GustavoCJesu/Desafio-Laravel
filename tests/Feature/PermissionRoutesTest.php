<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

test('a user without the permission is forbidden from the protected pages', function (string $routeName) {
    $user = User::factory()->create(['user_role_id' => null]);

    $this->actingAs($user)->get(route($routeName))->assertForbidden();
})->with(['epi.index', 'training.index', 'employees.index', 'report.index']);

test('a user whose role has the permission is not forbidden', function (string $routeName, string $slug) {
    $response = $this->actingAs(userWithPermissions('ativo', $slug))->get(route($routeName));

    expect($response->status())->not->toBe(403);
})->with([
    ['epi.index', 'epis.view'],
    ['training.index', 'trainings.view'],
    ['employees.index', 'employees.view'],
    ['report.index', 'reports.view'],
]);

test('a permission for another resource does not open the page', function () {
    $this->actingAs(userWithPermissions('ativo', 'employees.view'))
        ->get(route('epi.index'))
        ->assertForbidden();
});

test('every protected route requires the expected permission slug', function (string $routeName, string $slug) {
    expect(Route::getRoutes()->getByName($routeName)->gatherMiddleware())->toContain("can:{$slug}");
})->with([
    ['employees.index', 'employees.view'],
    ['employees.profile', 'employees.view'],
    ['employees.create', 'employees.create'],
    ['employee.update', 'employees.update'],
    ['employees.change', 'employees.update'],
    ['user.create', 'employees.update'],
    ['epi.index', 'epis.view'],
    ['epi.create', 'epis.create'],
    ['epi.update', 'epis.update'],
    ['epi.delete', 'epis.delete'],
    ['training.index', 'trainings.view'],
    ['training.create', 'trainings.create'],
    ['training.update', 'trainings.update'],
    ['training.delete', 'trainings.delete'],
    ['training.attendance', 'trainings.update'],
    ['certificate.store', 'certificates.allow'],
    ['report.index', 'reports.view'],
]);
