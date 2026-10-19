<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Employee;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $certificates = Certificate::with(['employee', 'sessionTraining', 'instructor', 'epis'])
            ->latest('confirmed_at')
            ->get()
            ->map(fn (Certificate $certificate) => ['code' => sprintf('CERT-%s-%04d', $certificate->confirmed_at->format('Y'), $certificate->id), 'employee' => $certificate->employee->name, 'registration' => $certificate->employee->registration, 'course' => trim($certificate->sessionTraining->norm.' '.$certificate->sessionTraining->title), 'hours' => $certificate->sessionTraining->class_min, 'epis' => $certificate->epis->pluck('name')->all(), 'instructor' => $certificate->instructor->name, 'confirmed_at' => $certificate->confirmed_at->format('d/m/Y'), 'expires_at' => $certificate->expires_at->format('d/m/Y'), 'status' => $certificate->currentStatus()]);

        $counts = $certificates->countBy('status');

        return view('pages.certificates.index', compact('certificates', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Emite certificados apenas para os funcionários da seção que atingiram a carga horária mínima
     * e ainda não possuem certificado dela.
     */
    public function store(Request $request, SessionTraining $sessionTraining): RedirectResponse
    {
        try {
            $sessionTraining->load(['employees', 'epis', 'certificate']);

            $alreadyCertified = $sessionTraining->certificate->pluck('employee_id');
            $eligibleEmployees = $sessionTraining->employees
                ->reject(fn (Employee $employee) => $alreadyCertified->contains($employee->id))
                ->filter(fn (Employee $employee) => $sessionTraining->attendedHoursFor($employee) >= $sessionTraining->min_hours);

            if ($eligibleEmployees->isEmpty()) {
                return redirect()->back()->with('Error', 'Nenhum funcionário atingiu a carga horária mínima para receber o certificado.');
            }

            $confirmedAt = now();
            $expiresAt = $confirmedAt->copy()->addMonths($sessionTraining->validity_months);
            $epiIds = $sessionTraining->epis->pluck('id');

            DB::transaction(function () use ($sessionTraining, $eligibleEmployees, $confirmedAt, $expiresAt, $epiIds) {
                foreach ($eligibleEmployees as $employee) {
                    $certificate = $sessionTraining->certificate()->create([
                        'employee_id' => $employee->id,
                        'instructor_id' => $sessionTraining->instructor_id,
                        'status' => Certificate::STATUS_VALID,
                        'confirmed_at' => $confirmedAt,
                        'expires_at' => $expiresAt,
                    ]);

                    $certificate->epis()->attach($epiIds);
                }
            });

            return redirect()->back()->with('Success', $eligibleEmployees->count().' certificado(s) emitido(s) com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao emitir o certificado: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao tentar emitir os certificados.');
        }
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
