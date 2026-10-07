<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * A ordem importa: o RolePermissionSeeder referencia as permissões pelo id.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Ver funcionários', 'slug' => 'employees.view'],
            ['name' => 'Criar funcionários', 'slug' => 'employees.create'],
            ['name' => 'Apagar funcionários', 'slug' => 'employees.delete'],
            ['name' => 'Editar funcionários', 'slug' => 'employees.update'],
            ['name' => 'Ver treinamentos', 'slug' => 'trainings.view'],
            ['name' => 'Criar treinamentos', 'slug' => 'trainings.create'],
            ['name' => 'Apagar treinamentos', 'slug' => 'trainings.delete'],
            ['name' => 'Editar treinamentos', 'slug' => 'trainings.update'],
            ['name' => 'Permitir certificados', 'slug' => 'certificates.allow'],
            ['name' => 'Ver EPIs', 'slug' => 'epis.view'],
            ['name' => 'Criar EPIs', 'slug' => 'epis.create'],
            ['name' => 'Apagar EPIs', 'slug' => 'epis.delete'],
            ['name' => 'Editar EPIs', 'slug' => 'epis.update'],
            ['name' => 'Ver relatórios', 'slug' => 'reports.view'],
            ['name' => 'Criar relatórios', 'slug' => 'reports.create'],
            ['name' => 'Apagar relatórios', 'slug' => 'reports.delete'],
            ['name' => 'Exportar relatórios', 'slug' => 'reports.export'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
