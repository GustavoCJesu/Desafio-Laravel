<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Category::create([
            'name' => 'Protetor de ouvido'
        ]);

        Category::create([
            'name' => 'Proteção facial'
        ]);

        Category::create([
            'name' => 'Proteção ocular'
        ]);

        Category::create([
            'name' => 'Proteção respiratória'
        ]);

        Category::create([
            'name' => 'Proteção das mãos'
        ]);

        Category::create([
            'name' => 'Proteção dos pés'
        ]);

        Category::create([
            'name' => 'Proteção da cabeça'
        ]);

        Category::create([
            'name' => 'Proteção auditiva'
        ]);

        Category::create([
            'name' => 'Proteção contra quedas'
        ]);

        Category::create([
            'name' => 'Proteção do corpo'
        ]);

        // Schema::create('categories', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->timestamps();
        // });
    }
}
