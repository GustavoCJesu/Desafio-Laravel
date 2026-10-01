<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SessionTrainingController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        $trainings   = SessionTraining::get();
        $instructors = Employee::get();

        return view('pages.trainings.index', compact('trainings', 'instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            SessionTraining::create($request->all());
            return redirect()->back()->with('Success', 'Sala de aula criada com sucesso!');
        } catch (Exception $e) {
            Log::error('Error'.$e->getMessage());
            return redirect()->back()->with('Error', 'Não foi possivel criar a sala de aula.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(SessionTraining $sessionTraining) {
        if(!$sessionTraining){
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma aula com esse ID localizada'
            ], 404);
        }else{
            return response()->json([
                'success' => true,
                'training' => $sessionTraining->employees,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionTraining $sessionTraining): View {
        $training  = $sessionTraining->load(['epis', 'classes', 'employees']);
        $employees = Employee::with('sector')->where('status', 'Ativo')->orderBy('name')->get();
        $epis      = Epi::with('category')->where('status', 'Ativo')->orderBy('name')->get();

        return view('pages.trainings.edit', compact('training', 'employees', 'epis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionTraining $sessionTraining) {

        $sessionTraining->loadCount('employees');

        try{

            $sessionTraining->update($request->all());
            return redirect()->back()->with('Success', 'Aula editada com sucesso.');
        }catch(Exception $e){
            Log::error('Error'. $e->getMessage());
            return redirect()->back()->with('Error', 'Não foi possivel editar a aula, mais informações no arquivo de log');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionTraining $sessionTraining) {
        //
    }

    public function vincEpi(Request $request, int $sessionTraining){

        try{
            $epis    = Epi::findOrFail($request->input('epis'));
            $session = SessionTraining::findOrFail($sessionTraining);
            $session->epis()->sync($epis);

            return redirect()->back()->with('Success', 'EPIs vinculados com sucesso.');
        }catch(Exception $e){
            Log::error('Error'. $e->getMessage());
            return redirect()->back()->with('Error', 'Não foi possivel vincular os EPIs, mais informações no arquivo de log');
        }
    }

    public function createClass(Request $request, SessionTraining $sessionTraining){
        $sessionTraining->loadCount('classes');
        $quantidadeAulas = $sessionTraining->classes_count;

        try{
            if($quantidadeAulas >= $sessionTraining->class_amount){
                return redirect()->back()->with('Error', 'Numero maximo de aulas atingido.');
            }else{
                Classes::create([
                    'session_training_id' => $sessionTraining->id,
                    'class_dt' => $request->class_dt
                ]);
            }


            return redirect()->back()->with('Success', 'Aula criada com sucesso.');
        }catch(Exception $e){
            Log::error('Error'. $e->getMessage());
            return redirect()->back()->with('Error', 'Erro ao criar a aula, mais informações no arquivo de log');
        }

    }

    public function deleteClass(Request $request, SessionTraining $sessionTraining, int $id){

        try{
            $class = Classes::findOrFail($id);
            $class->delete();

            return redirect()->back()->with('Success', 'Aula removida com sucesso.');
        }catch(Exception $e){
            Log::error('Error'. $e->getMessage());
            return redirect()->back()->with('Error', 'Erro ao remover a aula, mais informações no arquivo de log');
        }

    }

    public function vincEmployee(Request $request, int $sessionTraining) {
        $employees         = Employee::findOrFail($request->input('employees'));
        $session           = SessionTraining::findOrFail($sessionTraining);
        $session_employees = $session->loadCount('employees');

        try{
            if(count($employees) <= $session->capacity){
                $session->employees()->sync($employees);
                return redirect()->back()->with('Success', 'Funcionarios adicionados com sucesso.');
            }else{
                return redirect()->back()->with('Error', 'Quantidade maxima de convocados atingido.');
            }

        }catch(Exception $e){
            Log::error('Error'. $e->getMessage());
            return redirect()->back()->with('Error', 'Não foi possivel vincular o funcionario a aula, mais informações no arquivo de log');
        }

    }
}
