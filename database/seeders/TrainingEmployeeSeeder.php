<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\SessionTraining;
use Illuminate\Database\Seeder;

class TrainingEmployeeSeeder extends Seeder
{
    /**
     * Inscreve uma parte dos funcionários ativos em cada aula, sem ultrapassar as vagas
     * e sem incluir o próprio instrutor.
     */
    public function run(): void
    {
        foreach (SessionTraining::all() as $training) {
            $employeeIds = Employee::query()
                ->where('status', 'Ativo')
                ->where('id', '!=', $training->instructor_id)
                ->inRandomOrder()
                ->limit(rand(3, min($training->capacity, 10)))
                ->pluck('id');

            $training->employees()->sync($employeeIds);
        }
    }
}
