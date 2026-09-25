<?php

namespace App\Http\Controllers;

use App\Models\AttendenceSession;
use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(SessionTraining $training): View
    {
        $employees = Employee::all();
        $classes = $training->classes()->orderBy('class_dt')->get();
        $attendancesByClass = AttendenceSession::with('employee')
            ->whereIn('classes_id', $classes->pluck('id'))
            ->get()
            ->groupBy('classes_id');

        $epis = Epi::all();
        $linkedEpis = $training->epis()->get();

        return view('attendance', compact('training', 'employees', 'classes', 'attendancesByClass', 'epis', 'linkedEpis'));
    }

    public function store(Request $request, SessionTraining $training)
    {
        try {
            AttendenceSession::create([
                'employee_id' => $request->employee_id,
                'classes_id' => $request->classes_id,
                'employee_attendence' => $request->employee_attendence,
            ]);

            return redirect()->back()->with('Success', 'Funcionário vinculado à aula com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao vincular funcionário à aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível vincular o funcionário à aula.');
        }
    }

    public function destroy(SessionTraining $training, AttendenceSession $attendance)
    {
        try {
            $attendance->delete();

            return redirect()->back()->with('Success', 'Funcionário removido da aula com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao remover funcionário da aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível remover o funcionário da aula.');
        }
    }

    public function storeEpi(Request $request, SessionTraining $training)
    {
        try {
            $training->epis()->syncWithoutDetaching([$request->epi_id]);

            return redirect()->back()->with('Success', 'EPI vinculado à aula com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao vincular EPI à aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível vincular o EPI à aula.');
        }
    }

    public function destroyEpi(SessionTraining $training, Epi $epi)
    {
        try {
            $training->epis()->detach($epi->id);

            return redirect()->back()->with('Success', 'EPI removido da aula com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao remover EPI da aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível remover o EPI da aula.');
        }
    }
}
