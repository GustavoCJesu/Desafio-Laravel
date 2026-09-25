<?php

namespace Database\Factories;

use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_role_id' => CompanyRole::factory(),
            'sector_id' => Sector::factory(),
            'registration' => Employee::generateRegistration(),
            'name' => fake()->name(),
            'cpf' => fake()->unique()->numerify('###.###.###-##'),
            'hire_date' => fake()->date(),
            'status' => 'Ativo',
        ];
    }
}
