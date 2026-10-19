<?php

namespace Database\Seeders;

use App\Models\SessionTraining;
use Illuminate\Database\Seeder;

class SessionTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SessionTraining::create([
            'instructor_id' => 2,
            'norm' => 'NR-35',
            'title' => 'Trabalho em Altura',
            'description' => 'Análise de risco, sistemas de ancoragem e uso de cinturão tipo paraquedista.',
            'status' => 'Agendado',
            'class_amount' => 1,
            'class_min' => 8,
            'min_hours' => 8,
            'capacity' => 20,
            'location' => 'Sala de treinamento 1',
            'validity_months' => 24,
        ]);

        SessionTraining::create([
            'instructor_id' => 6,
            'norm' => 'NR-06',
            'title' => 'Uso correto de EPI',
            'description' => 'Seleção, uso, guarda e conservação dos equipamentos de proteção individual.',
            'status' => 'Agendado',
            'class_amount' => 1,
            'class_min' => 4,
            'min_hours' => 4,
            'capacity' => 30,
            'location' => 'Auditório',
            'validity_months' => 12,
        ]);

        SessionTraining::create([
            'instructor_id' => 3,
            'norm' => 'NR-10',
            'title' => 'Segurança em Eletricidade',
            'description' => 'Riscos elétricos, medidas de controle e procedimentos de trabalho em instalações energizadas.',
            'status' => 'Agendado',
            'class_amount' => 5,
            'class_min' => 40,
            'min_hours' => 40,
            'capacity' => 15,
            'location' => 'Laboratório elétrico',
            'validity_months' => 24,
        ]);

        SessionTraining::create([
            'instructor_id' => 2,
            'norm' => 'NR-33',
            'title' => 'Espaço Confinado',
            'description' => 'Reconhecimento de espaços confinados, permissão de entrada e resgate.',
            'status' => 'Agendado',
            'class_amount' => 2,
            'class_min' => 16,
            'min_hours' => 16,
            'capacity' => 12,
            'location' => 'Área externa',
            'validity_months' => 12,
        ]);

        SessionTraining::create([
            'instructor_id' => 4,
            'norm' => 'NR-12',
            'title' => 'Máquinas e Equipamentos',
            'description' => 'Dispositivos de segurança, proteções fixas e móveis e bloqueio de energias.',
            'status' => 'Concluído',
            'class_amount' => 1,
            'class_min' => 8,
            'min_hours' => 8,
            'capacity' => 22,
            'location' => 'Galpão B',
            'validity_months' => 24,
        ]);

        SessionTraining::create([
            'instructor_id' => 6,
            'norm' => 'NR-23',
            'title' => 'Proteção contra Incêndios',
            'description' => 'Classes de incêndio, uso de extintores e rotas de evacuação.',
            'status' => 'Concluído',
            'class_amount' => 1,
            'class_min' => 4,
            'min_hours' => 4,
            'capacity' => 30,
            'location' => 'Pátio central',
            'validity_months' => 12,
        ]);

        SessionTraining::create([
            'instructor_id' => 3,
            'norm' => 'NR-11',
            'title' => 'Operação de Empilhadeira',
            'description' => 'Inspeção pré-operacional, estabilidade de carga e circulação segura.',
            'status' => 'Cancelado',
            'class_amount' => 2,
            'class_min' => 16,
            'min_hours' => 16,
            'capacity' => 10,
            'location' => 'Depósito',
            'validity_months' => 12,
        ]);
    }
}
