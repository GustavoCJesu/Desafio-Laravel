<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {

        Employee::create([
            'company_role_id' => 1,
            'sector_id' => 1,
            'registration' => '5223-2',
            'name' => 'Gustavo Conti Jesuino',
            'cpf' => '153.429.526-70',
            'hire_date' => '2026-05-05',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 2,
            'sector_id' => 1,
            'registration' => '4831-7',
            'name' => 'Mariana Alves Costa',
            'cpf' => '284.615.937-81',
            'hire_date' => '2025-08-12',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 3,
            'sector_id' => 2,
            'registration' => '6312-4',
            'name' => 'Rafael Henrique Souza',
            'cpf' => '395.726.148-92',
            'hire_date' => '2024-11-18',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 4,
            'sector_id' => 3,
            'registration' => '7145-9',
            'name' => 'Camila Fernanda Lima',
            'cpf' => '416.837.259-03',
            'hire_date' => '2026-01-20',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 5,
            'sector_id' => 4,
            'registration' => '3521-6',
            'name' => 'Lucas Gabriel Martins',
            'cpf' => '527.948.361-14',
            'hire_date' => '2023-06-15',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 6,
            'sector_id' => 5,
            'registration' => '8294-1',
            'name' => 'Fernanda Cristina Oliveira',
            'cpf' => '638.159.472-25',
            'hire_date' => '2022-09-10',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 7,
            'sector_id' => 5,
            'registration' => '4678-3',
            'name' => 'João Pedro Ribeiro',
            'cpf' => '749.261.583-36',
            'hire_date' => '2025-02-03',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 8,
            'sector_id' => 5,
            'registration' => '9152-8',
            'name' => 'Bruno Henrique Santos',
            'cpf' => '851.372.694-47',
            'hire_date' => '2026-03-11',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 9,
            'sector_id' => 6,
            'registration' => '2467-5',
            'name' => 'André Luiz Ferreira',
            'cpf' => '962.483.715-58',
            'hire_date' => '2024-04-22',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 10,
            'sector_id' => 2,
            'registration' => '5836-9',
            'name' => 'Patrícia Regina Mendes',
            'cpf' => '173.594.826-69',
            'hire_date' => '2021-12-01',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 3,
            'sector_id' => 7,
            'registration' => '6942-2',
            'name' => 'Thiago Augusto Barbosa',
            'cpf' => '284.615.937-70',
            'hire_date' => '2025-07-14',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 7,
            'sector_id' => 5,
            'registration' => '7315-4',
            'name' => 'Carlos Eduardo Nunes',
            'cpf' => '395.726.148-81',
            'hire_date' => '2023-10-09',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 8,
            'sector_id' => 9,
            'registration' => '8452-7',
            'name' => 'Diego Rafael Almeida',
            'cpf' => '416.837.259-92',
            'hire_date' => '2024-01-17',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 4,
            'sector_id' => 3,
            'registration' => '3186-5',
            'name' => 'Juliana Beatriz Rocha',
            'cpf' => '527.948.361-03',
            'hire_date' => '2025-05-26',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 5,
            'sector_id' => 4,
            'registration' => '5629-8',
            'name' => 'Renata Cristina Dias',
            'cpf' => '638.159.472-14',
            'hire_date' => '2022-08-30',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 9,
            'sector_id' => 6,
            'registration' => '6743-1',
            'name' => 'Marcelo Vinícius Cardoso',
            'cpf' => '749.261.583-25',
            'hire_date' => '2026-02-08',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 2,
            'sector_id' => 1,
            'registration' => '7821-6',
            'name' => 'Aline Gabriela Moreira',
            'cpf' => '851.372.694-36',
            'hire_date' => '2024-06-19',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 6,
            'sector_id' => 5,
            'registration' => '4937-3',
            'name' => 'Roberto Carlos Teixeira',
            'cpf' => '962.483.715-47',
            'hire_date' => '2020-03-16',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 3,
            'sector_id' => 10,
            'registration' => '6184-9',
            'name' => 'Beatriz Helena Ramos',
            'cpf' => '173.594.826-58',
            'hire_date' => '2025-11-04',
            'status' => 'Ativo',
        ]);

        Employee::create([
            'company_role_id' => 7,
            'sector_id' => 8,
            'registration' => '9275-2',
            'name' => 'Felipe Matheus Castro',
            'cpf' => '284.615.937-69',
            'hire_date' => '2023-02-27',
            'status' => 'Ativo',
        ]);
    }
}
