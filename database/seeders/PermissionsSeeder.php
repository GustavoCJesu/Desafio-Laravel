<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Ver funcionários',
        ]);

        Permission::create([
            'name' => 'Criar funcionários',
        ]);

        Permission::create([
            'name' => 'Apagar funcionários',
        ]);

        Permission::create([
            'name' => 'Editar funcionários',
        ]);

        Permission::create([
            'name' => 'Ver treinamentos',
        ]);

        Permission::create([
            'name' => 'Criar treinamentos',
        ]);

        Permission::create([
            'name' => 'Apagar treinamentos',
        ]);

        Permission::create([
            'name' => 'Editar treinamentos',
        ]);

        Permission::create([
            'name' => 'Permitir certificados',
        ]);

        Permission::create([
            'name' => 'Ver EPIs',
        ]);

        Permission::create([
            'name' => 'Criar EPIs',
        ]);

        Permission::create([
            'name' => 'Apagar EPIs',
        ]);

        Permission::create([
            'name' => 'Editar EPIs',
        ]);

        Permission::create([
            'name' => 'Ver relatórios',
        ]);

        Permission::create([
            'name' => 'Criar relatórios',
        ]);

        Permission::create([
            'name' => 'Apagar relatórios',
        ]);

        Permission::create([
            'name' => 'Exportar relatórios',
        ]);
    }
}
