<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = $this->mockedCertificates();

        return view('certificate', compact('certificates'));
    }

    /**
     * @return Collection<int, object>
     */
    private function mockedCertificates(): Collection
    {
        return collect([
            (object) [
                'id' => 1,
                'employee' => (object) ['name' => 'João Silva'],
                'instructor' => (object) ['name' => 'Gustavo Jesuino'],
                'sessionTraining' => (object) ['title' => 'NR-06 Uso de EPI'],
                'confirmed_at' => Carbon::parse('2026-08-15'),
                'expires_at' => Carbon::parse('2027-08-15'),
                'status' => 'Válido',
            ],
            (object) [
                'id' => 2,
                'employee' => (object) ['name' => 'Bruno Almeida'],
                'instructor' => (object) ['name' => 'Mariana Costa'],
                'sessionTraining' => (object) ['title' => 'NR-35 Trabalho em Altura'],
                'confirmed_at' => Carbon::parse('2025-09-18'),
                'expires_at' => Carbon::parse('2026-09-18'),
                'status' => 'Expirado',
            ],
            (object) [
                'id' => 3,
                'employee' => (object) ['name' => 'Fernanda Lima'],
                'instructor' => (object) ['name' => 'Rafael Souza'],
                'sessionTraining' => (object) ['title' => 'NR-10 Segurança em Eletricidade'],
                'confirmed_at' => Carbon::parse('2026-01-10'),
                'expires_at' => Carbon::parse('2028-01-10'),
                'status' => 'Válido',
            ],
            (object) [
                'id' => 4,
                'employee' => (object) ['name' => 'André Pereira'],
                'instructor' => (object) ['name' => 'Camila Rocha'],
                'sessionTraining' => (object) ['title' => 'NR-33 Espaços Confinados'],
                'confirmed_at' => Carbon::parse('2026-06-01'),
                'expires_at' => Carbon::parse('2026-12-01'),
                'status' => 'Válido',
            ],
        ]);
    }
}
