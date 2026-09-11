<?php

namespace Database\Seeders;

use App\Models\Epi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpiSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Epi::create([
            'name' => 'Protetor auricular',
            'category_id' => 1,
            'ca' => '255255',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Abafador de ruído',
            'category_id' => 8,
            'ca' => '314159',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Protetor facial',
            'category_id' => 2,
            'ca' => '271828',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Óculos de proteção incolor',
            'category_id' => 3,
            'ca' => '161803',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Óculos de proteção fumê',
            'category_id' => 3,
            'ca' => '141421',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Respirador semifacial',
            'category_id' => 4,
            'ca' => '173205',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Máscara respiratória PFF2',
            'category_id' => 4,
            'ca' => '223606',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Respirador facial inteiro',
            'category_id' => 4,
            'ca' => '244949',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Luva de proteção nitrílica',
            'category_id' => 5,
            'ca' => '316227',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Luva de proteção de raspa',
            'category_id' => 5,
            'ca' => '331662',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Luva anticorte',
            'category_id' => 5,
            'ca' => '346410',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Bota de segurança com biqueira',
            'category_id' => 6,
            'ca' => '360555',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Botina de segurança',
            'category_id' => 6,
            'ca' => '374165',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Capacete de segurança',
            'category_id' => 7,
            'ca' => '387298',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Capacete com proteção facial',
            'category_id' => 7,
            'ca' => '400000',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Cinturão de segurança tipo paraquedista',
            'category_id' => 9,
            'ca' => '412310',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Talabarte de segurança',
            'category_id' => 9,
            'ca' => '424264',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Macacão de proteção',
            'category_id' => 10,
            'ca' => '435889',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Avental de proteção',
            'category_id' => 10,
            'ca' => '447214',
            'status' => 'Ativo'
        ]);

        Epi::create([
            'name' => 'Colete de proteção',
            'category_id' => 10,
            'ca' => '458258',
            'status' => 'Ativo'
        ]);

        // Schema::create('epis', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->foreignIdFor(Category::class, 'category_id')->constrained('categories');
        //     $table->string('ca')->unique();
        //     $table->string('status');
        //     $table->timestamps();
        // });
    }
}
