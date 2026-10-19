<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 1,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 2,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 3,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 4,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 5,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 6,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 7,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 8,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 9,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 10,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 11,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 12,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 13,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 14,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 15,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 16,
        ]);

        RolePermission::create([
            'user_role_id' => 1,
            'permission_id' => 17,
        ]);

        RolePermission::create(['user_role_id' => 1, 'permission_id' => 18]);
        RolePermission::create(['user_role_id' => 1, 'permission_id' => 19]);
        RolePermission::create(['user_role_id' => 1, 'permission_id' => 20]);
        RolePermission::create(['user_role_id' => 1, 'permission_id' => 21]);

        RolePermission::create(['user_role_id' => 2, 'permission_id' => 1]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 2]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 3]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 4]);

        RolePermission::create(['user_role_id' => 2, 'permission_id' => 5]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 6]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 7]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 8]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 9]);

        RolePermission::create(['user_role_id' => 2, 'permission_id' => 10]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 11]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 12]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 13]);

        RolePermission::create(['user_role_id' => 2, 'permission_id' => 14]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 15]);
        RolePermission::create(['user_role_id' => 2, 'permission_id' => 17]);

        RolePermission::create([
            'user_role_id' => 3,
            'permission_id' => 1,
        ]);

        RolePermission::create([
            'user_role_id' => 3,
            'permission_id' => 5,
        ]);

        RolePermission::create([
            'user_role_id' => 3,
            'permission_id' => 9,
        ]);

        RolePermission::create([
            'user_role_id' => 3,
            'permission_id' => 10,
        ]);

        RolePermission::create([
            'user_role_id' => 3,
            'permission_id' => 14,
        ]);

        RolePermission::create(['user_role_id' => 4, 'permission_id' => 1]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 2]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 3]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 4]);

        RolePermission::create(['user_role_id' => 4, 'permission_id' => 5]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 6]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 7]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 8]);
        RolePermission::create(['user_role_id' => 4, 'permission_id' => 9]);

        RolePermission::create([
            'user_role_id' => 4,
            'permission_id' => 10,
        ]);

        RolePermission::create([
            'user_role_id' => 4,
            'permission_id' => 14,
        ]);

        RolePermission::create([
            'user_role_id' => 4,
            'permission_id' => 17,
        ]);

        RolePermission::create([
            'user_role_id' => 5,
            'permission_id' => 1,
        ]);

        RolePermission::create([
            'user_role_id' => 5,
            'permission_id' => 5,
        ]);

        RolePermission::create([
            'user_role_id' => 5,
            'permission_id' => 10,
        ]);

        RolePermission::create([
            'user_role_id' => 5,
            'permission_id' => 14,
        ]);

        // Professor: cria e gerencia aulas (5 a 8) e consulta funcionários (1) e EPIs (10).
        foreach ([1, 5, 6, 7, 8, 10] as $permissionId) {
            RolePermission::create(['user_role_id' => 6, 'permission_id' => $permissionId]);
        }

        // Schema::create('role_permissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignIdFor(UserRole::class, 'user_role_id')->constrained('user_roles');
        //     $table->foreignIdFor(Permission::class, 'permission_id')->constrained('permissions');
        //     $table->timestamps();
        // });
    }
}
