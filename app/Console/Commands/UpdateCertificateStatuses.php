<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

#[Signature('certificates:update-status')]
#[Description('Atualiza no banco a situação (Válido, A vencer, Vencido) dos certificados pela data de validade')]
class UpdateCertificateStatuses extends Command
{
    /**
     * Cada faixa de data vira um único UPDATE, e só as linhas com situação desatualizada são alteradas.
     * Os limites seguem Certificate::statusForDate(): vence ao fim do dia de vencimento.
     */
    public function handle(): int
    {
        $today = today()->toDateString();
        $expiringLimit = today()->addDays(Certificate::EXPIRING_DAYS)->toDateString();

        $updated = [
            Certificate::STATUS_EXPIRED => $this->setStatus(
                Certificate::where('expires_at', '<', $today),
                Certificate::STATUS_EXPIRED
            ),
            Certificate::STATUS_EXPIRING => $this->setStatus(
                Certificate::whereBetween('expires_at', [$today, $expiringLimit]),
                Certificate::STATUS_EXPIRING
            ),
            Certificate::STATUS_VALID => $this->setStatus(
                Certificate::where('expires_at', '>', $expiringLimit),
                Certificate::STATUS_VALID
            ),
        ];

        $this->table(['Passou para', 'Certificados'], collect($updated)->map(fn (int $total, string $status) => [$status, $total])->values());

        return self::SUCCESS;
    }

    /**
     * @param  Builder<Certificate>  $query
     */
    private function setStatus(Builder $query, string $status): int
    {
        return $query->where('status', '!=', $status)->update(['status' => $status]);
    }
}
