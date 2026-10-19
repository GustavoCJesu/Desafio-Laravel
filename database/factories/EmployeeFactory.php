<?php

namespace Database\Factories;

use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory {
    public function definition(): array {
        return [
            'company_role_id' => CompanyRole::inRandomOrder()->value('id'),
            'sector_id' => Sector::inRandomOrder()->value('id'),
            'registration' => fake()->unique()->numerify('#####-#'),
            'name' => fake('pt_BR')->name(),
            'cpf' => fake()->unique()->numerify('###.###.###-##'),
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now')
            ->format('Y-m-d'),
            'status' => fake()->randomElement(['Ativo', 'Inativo']),
        ];
    }
}
