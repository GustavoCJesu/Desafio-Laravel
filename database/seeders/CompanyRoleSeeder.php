<?php

namespace Database\Seeders;

use App\Models\CompanyRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyRoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        CompanyRole::create([
            'title' => 'Auxiliar de compras',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Analista de compras',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Assistente administrativo',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Técnico de segurança do trabalho',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Analista de recursos humanos',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Supervisor de produção',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Operador de máquinas',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Auxiliar de produção',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Almoxarife',
            'status' => 'Ativo',
        ]);

        CompanyRole::create([
            'title' => 'Gerente administrativo',
            'status' => 'Ativo',
        ]);
    }
}
