<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\SessionTraining;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CertificateSeeder extends Seeder
{
    /**
     * Emite certificados para os convocados das aulas concluídas, com datas de emissão
     * e validades variadas para cobrir os status Válido, A vencer e Vencido.
     */
    public function run(): void
    {
        $trainings = SessionTraining::with(['employees', 'epis'])->where('status', 'Concluído')->get();

        foreach ($trainings as $training) {
            foreach ($training->employees as $employee) {
                $confirmedAt = now()->subMonths(rand(1, 30))->startOfDay();
                $expiresAt = $confirmedAt->copy()->addMonths(collect([12, 24])->random());

                $certificate = Certificate::create([
                    'instructor_id' => $training->instructor_id,
                    'employee_id' => $employee->id,
                    'session_training_id' => $training->id,
                    'confirmed_at' => $confirmedAt,
                    'expires_at' => $expiresAt,
                    'status' => $this->statusFor($expiresAt),
                ]);

                $certificate->epis()->attach($training->epis->pluck('id'));
            }
        }
    }

    private function statusFor(Carbon $expiresAt): string
    {
        if ($expiresAt->isPast()) {
            return 'Vencido';
        }

        return now()->diffInDays($expiresAt) <= 60 ? 'A vencer' : 'Válido';
    }
}
