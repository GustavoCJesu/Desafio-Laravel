<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('a user can perform the abilities whose slug the role has', function () {
    $user = userWithPermissions('ativo', 'epis.view');

    expect($user->can('epis.view'))->toBeTrue()
        ->and($user->can('epis.create'))->toBeFalse();
});

test('an inactive role grants no permission', function () {
    $user = userWithPermissions('inativo', 'epis.view');

    expect($user->can('epis.view'))->toBeFalse();
});

test('the role status is compared regardless of letter case', function () {
    $user = userWithPermissions('Ativo', 'epis.view');

    expect($user->can('epis.view'))->toBeTrue();
});

test('a user without a role has no permission', function () {
    $user = User::factory()->create(['user_role_id' => null]);

    expect($user->can('epis.view'))->toBeFalse();
});

test('a missing permission still lets other gates decide', function () {
    Gate::define('issue-certificates', fn (User $user) => true);
    $user = userWithPermissions('ativo');

    expect($user->can('issue-certificates'))->toBeTrue();
});
