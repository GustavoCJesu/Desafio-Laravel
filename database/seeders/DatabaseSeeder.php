<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(SectorSeeder::class);
        $this->call(CompanyRoleSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(EpiSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SessionTrainingSeeder::class);
        $this->call(TrainingEmployeeSeeder::class);

    }
}
