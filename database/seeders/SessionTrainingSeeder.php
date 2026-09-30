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
            'scheduled' => '2026-10-02 08:00:00',
            'status' => 'Agendado',
            'class_amount' => 1,
            'class_min' => 8,
            'capacity' => 20,
            'location' => 'Sala de treinamento 1',
            'validity_dt' => '2028-10-02',
        ]);

        SessionTraining::create([
            'instructor_id' => 6,
            'norm' => 'NR-06',
            'title' => 'Uso correto de EPI',
            'description' => 'Seleção, uso, guarda e conservação dos equipamentos de proteção individual.',
            'scheduled' => '2026-10-05 14:00:00',
            'status' => 'Agendado',
            'class_amount' => 1,
            'class_min' => 4,
            'capacity' => 30,
            'location' => 'Auditório',
            'validity_dt' => '2027-10-05',
        ]);

        SessionTraining::create([
            'instructor_id' => 3,
            'norm' => 'NR-10',
            'title' => 'Segurança em Eletricidade',
            'description' => 'Riscos elétricos, medidas de controle e procedimentos de trabalho em instalações energizadas.',
            'scheduled' => '2026-10-09 08:30:00',
            'status' => 'Agendado',
            'class_amount' => 5,
            'class_min' => 40,
            'capacity' => 15,
            'location' => 'Laboratório elétrico',
            'validity_dt' => '2028-10-09',
        ]);

        SessionTraining::create([
            'instructor_id' => 2,
            'norm' => 'NR-33',
            'title' => 'Espaço Confinado',
            'description' => 'Reconhecimento de espaços confinados, permissão de entrada e resgate.',
            'scheduled' => '2026-10-14 09:00:00',
            'status' => 'Agendado',
            'class_amount' => 2,
            'class_min' => 16,
            'capacity' => 12,
            'location' => 'Área externa',
            'validity_dt' => '2027-10-14',
        ]);

        SessionTraining::create([
            'instructor_id' => 4,
            'norm' => 'NR-12',
            'title' => 'Máquinas e Equipamentos',
            'description' => 'Dispositivos de segurança, proteções fixas e móveis e bloqueio de energias.',
            'scheduled' => '2026-09-18 08:00:00',
            'status' => 'Concluído',
            'class_amount' => 1,
            'class_min' => 8,
            'capacity' => 22,
            'location' => 'Galpão B',
            'validity_dt' => '2028-09-18',
        ]);

        SessionTraining::create([
            'instructor_id' => 6,
            'norm' => 'NR-23',
            'title' => 'Proteção contra Incêndios',
            'description' => 'Classes de incêndio, uso de extintores e rotas de evacuação.',
            'scheduled' => '2026-09-10 13:30:00',
            'status' => 'Concluído',
            'class_amount' => 1,
            'class_min' => 4,
            'capacity' => 30,
            'location' => 'Pátio central',
            'validity_dt' => '2027-09-10',
        ]);

        SessionTraining::create([
            'instructor_id' => 3,
            'norm' => 'NR-11',
            'title' => 'Operação de Empilhadeira',
            'description' => 'Inspeção pré-operacional, estabilidade de carga e circulação segura.',
            'scheduled' => '2026-08-28 08:00:00',
            'status' => 'Cancelado',
            'class_amount' => 2,
            'class_min' => 16,
            'capacity' => 10,
            'location' => 'Depósito',
            'validity_dt' => '2027-08-28',
        ]);
    }
}
