<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        UserRole::create([
            'title' => 'admin',
            'status' => 'ativo'
        ]);

        UserRole::create([
            'title' => 'gestor',
            'status' => 'ativo'
        ]);

        UserRole::create([
            'title' => 'colaborador',
            'status' => 'ativo'
        ]);

        UserRole::create([
            'title' => 'supervisor',
            'status' => 'ativo'
        ]);

        UserRole::create([
            'title' => 'visualizador',
            'status' => 'ativo'
        ]);

        // Schema::create('user_roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title');
        //     $table->string('status');
        //     $table->timestamps();
        // });
    }
}
