<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $certificates = Certificate::with(['employee', 'sessionTraining', 'instructor'])
            ->latest('confirmed_at')
            ->get()
            ->map(fn (Certificate $certificate) => ['code' => sprintf('CERT-%s-%04d', $certificate->confirmed_at->format('Y'), $certificate->id), 'employee' => $certificate->employee->name, 'registration' => $certificate->employee->registration, 'course' => $certificate->sessionTraining->norm.' '.$certificate->sessionTraining->title, 'hours' => $certificate->sessionTraining->class_min, 'instructor' => $certificate->instructor->name, 'confirmed_at' => $certificate->confirmed_at->format('d/m/Y'), 'expires_at' => $certificate->expires_at->format('d/m/Y'), 'status' => $this->statusFor($certificate->expires_at)]);

        $counts = $certificates->countBy('status');

        return view('pages.certificates.index', compact('certificates', 'counts'));
    }

    private function statusFor(Carbon $expiresAt): string
    {
        if ($expiresAt->isPast()) {
            return 'Vencido';
        }

        return now()->diffInDays($expiresAt) <= 60 ? 'A vencer' : 'Válido';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $id)
    {

        try {
            $session = SessionTraining::findOrFail($id);

            $instructor = $session->instructor;
            $employees = $session->employees;
            $id = $session->id;
            $confirmed_at = now();
            $status = 'Válido';
            $epis = $session->epis->pluck('id')->toArray();
            $expires_at = now()->addMonths($session->validity_months);

            $certificateData = $employees->map(function ($employee) use ($instructor, $status, $expires_at, $confirmed_at) {
                return [
                    'employee_id' => $employee->id,
                    'instructor_id' => $instructor->id,
                    'status' => $status,
                    'confirmed_at' => $confirmed_at,
                    'expires_at' => $expires_at,
                ];
            })->toArray();

            $createCertificate = $session->certificate()->createMany($certificateData);

            $certificateEpi = [];
            foreach ($createCertificate as $certificate) {
                foreach ($epis as $epi) {
                    $certificateEpi[] = [
                        'certificate_id' => $certificate->id,
                        'epi_id' => $epi,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            dump($certificateEpi);

            $teste = DB::table('certificate_epis')->insert($certificateEpi);

            dump($teste);

            return redirect()->back()->with('Success', 'Certificados emitidos com sucesso');

        } catch (Exception $e) {
            Log::error('Erro ao emitir o certificado, mais informações no arquivo de log.'.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao tentar emitir os certificados.');
        }
        // dump($certificateData);
        // dump($expires_at);
        // dump($employees[0]->certificate);
        // dump($session->employees);
        // dump($session->epis);
        // dump($session->instructor);
        // dump($request->all(), $session);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        //
    }
}
