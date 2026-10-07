<?php

use App\Models\Permission;
use Database\Seeders\PermissionsSeeder;

test('every seeded permission has a unique slug', function () {
    $this->seed(PermissionsSeeder::class);

    expect(Permission::count())->toBe(17)
        ->and(Permission::whereNull('slug')->orWhere('slug', '')->count())->toBe(0)
        ->and(Permission::distinct()->count('slug'))->toBe(17)
        ->and(Permission::where('slug', 'epis.view')->value('name'))->toBe('Ver EPIs');
});
