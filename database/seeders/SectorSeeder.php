<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder {
    public function run(): void {
        Sector::create([
            'name' => 'Setor de compras'
        ]);

        Sector::create([
            'name' => 'Setor administrativo'
        ]);

        Sector::create([
            'name' => 'Setor de segurança do trabalho'
        ]);

        Sector::create([
            'name' => 'Setor de recursos humanos'
        ]);

        Sector::create([
            'name' => 'Setor de produção'
        ]);

        Sector::create([
            'name' => 'Setor de almoxarifado'
        ]);

        Sector::create([
            'name' => 'Setor financeiro'
        ]);

        Sector::create([
            'name' => 'Setor de manutenção'
        ]);

        Sector::create([
            'name' => 'Setor de logística'
        ]);

        Sector::create([
            'name' => 'Setor de qualidade'
        ]);
    }
}
