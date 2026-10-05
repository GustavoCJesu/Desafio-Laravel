<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\SessionClassRequest;
use App\Http\Requests\SessionTrainingRequest;
use App\Http\Requests\TrainingEmployeesRequest;
use App\Http\Requests\TrainingEpisRequest;
use App\Models\AttendanceSession;
use App\Models\Classes;
use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SessionTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $trainings = SessionTraining::with('instructor')
            ->withMin(['classes as next_class_dt' => fn ($query) => $query->where('class_dt', '>=', now())], 'class_dt')
            ->withCount(['classes as completed_classes_count' => fn ($query) => $query->where('status', 'Concluído')])
            ->orderByRaw('next_class_dt IS NULL')
            ->orderBy('next_class_dt')
            ->orderBy('id')
            ->paginate(6);

        $instructors = Employee::get();
        $scheduled = SessionTraining::where('status', 'Agendado')->count();
        $completed = SessionTraining::where('status', 'Concluído')->count();
        $cancelled = SessionTraining::where('status', 'Cancelado')->count();
        $hours = SessionTraining::sum('class_min');
        $classes = Classes::get()->all();
        if (count(AttendanceSession::where('employee_attendance', '=', 'Compareceu')->get()) != 0 && count(AttendanceSession::get()->all()) * 100 != 0) {
            $attendance_rate = count(AttendanceSession::where('employee_attendance', '=', 'Compareceu')->get()) / count(AttendanceSession::get()->all()) * 100;
        } else {
            $attendance_rate = 0;
        }

        return view('pages.trainings.index', compact('trainings', 'instructors', 'scheduled', 'attendance_rate', 'completed', 'cancelled', 'hours', 'classes'));
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
    public function store(SessionTrainingRequest $request)
    {
        try {
            SessionTraining::create($request->validated());

            return redirect()->back()->with('Success', 'Sala de aula criada com sucesso!');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível criar a sala de aula.');
        }

    }

    public function edit(SessionTraining $sessionTraining): View
    {
        $training = $sessionTraining->load(['epis', 'classes', 'employees']);
        $employees = Employee::with('sector')->where('status', 'Ativo')->orderBy('name')->get();
        $epis = Epi::with('category')->where('status', 'Ativo')->orderBy('name')->get();

        return view('pages.trainings.edit', compact('training', 'employees', 'epis'));
    }

    public function update(SessionTrainingRequest $request, SessionTraining $sessionTraining)
    {
        $sessionTraining->loadCount('employees');
        try {
            $sessionTraining->update($request->validated());

            return redirect()->back()->with('Success', 'Aula editada com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível editar a aula, mais informações no arquivo de log');
        }

    }

    public function destroy(SessionTraining $sessionTraining): RedirectResponse
    {
        try {
            DB::transaction(function () use ($sessionTraining) {
                $classIds = $sessionTraining->classes()->pluck('id');

                AttendanceSession::whereIn('classes_id', $classIds)->delete();
                $sessionTraining->classes()->delete();
                $sessionTraining->epis()->detach();
                $sessionTraining->employees()->detach();
                $sessionTraining->delete();
            });

            return redirect()->back()->with('Success', 'Aula excluída com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível excluir a aula, mais informações no arquivo de log');
        }
    }

    public function vincEpi(TrainingEpisRequest $request, SessionTraining $sessionTraining)
    {
        try {
            $sessionTraining->epis()->sync($request->validated('epis', []));

            return redirect()->back()->with('Success', 'EPIs vinculados com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível vincular os EPIs, mais informações no arquivo de log');
        }
    }

    public function createClass(SessionClassRequest $request, SessionTraining $sessionTraining)
    {
        $sessionTraining->loadCount('classes');
        $quantidadeAulas = $sessionTraining->classes_count;

        try {
            if ($quantidadeAulas >= $sessionTraining->class_amount) {
                return redirect()->back()->with('Error', 'Número máximo de aulas atingido.');
            } else {
                Classes::create([
                    'session_training_id' => $sessionTraining->id,
                    'class_dt' => $request->validated('class_dt'),
                ]);
                $sessionTraining->syncStatusWithClasses();
            }

            return redirect()->back()->with('Success', 'Aula criada com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao criar a aula, mais informações no arquivo de log');
        }
    }

    public function completeClass(SessionTraining $sessionTraining, int $id): RedirectResponse
    {
        try {
            $sessionTraining->classes()->findOrFail($id)->update(['status' => 'Concluído']);
            $sessionTraining->syncStatusWithClasses();

            return redirect()->back()->with('Success', 'Aula concluída com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao concluir a aula, mais informações no arquivo de log');
        }
    }

    public function deleteClass(Request $request, SessionTraining $sessionTraining, int $id)
    {
        try {
            $class = $sessionTraining->classes()->findOrFail($id);
            $class->delete();
            $sessionTraining->syncStatusWithClasses();

            return redirect()->back()->with('Success', 'Aula removida com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao remover a aula, mais informações no arquivo de log');
        }

    }

    public function vincEmployee(TrainingEmployeesRequest $request, SessionTraining $sessionTraining)
    {
        try {
            $sessionTraining->employees()->sync($request->validated('employees', []));

            return redirect()->back()->with('Success', 'Funcionários adicionados com sucesso.');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível vincular o funcionário à aula, mais informações no arquivo de log');
        }
    }

    public function attendanceSession(AttendanceRequest $request)
    {
        try {

            $list = $request->validated('employees', []);
            $data = [];

            $class = Classes::findOrFail($request->validated('class_id'));
            $employees = $class->sessionTraining->employees;

            if ($class->status == 'Concluído') {
                return redirect()->back()->with('Error', 'Essa aula ja foi concluida, não é possivel alterar sua lista de presença.');
            }

            foreach ($employees as $employee) {
                $data[$employee->id] = [
                    'employee_attendance' => in_array($employee->id, $list)
                    ? 'Compareceu'
                    : 'Faltou',
                ];
            }
            if ($data === []) {
                return redirect()->back()->with('Error', 'Variavel data vazia');
            } else {
                $class->employees()->sync($data);
            }

            $this->completeClass($class->sessionTraining, $class->id);

            return redirect()->back()->with('Success', 'Lista de presença enviada');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());

            return redirect()->back()->with('Error', 'Erro ao enviar a lista de presença, mais informações no arquivo de log');
        }

    }
}
