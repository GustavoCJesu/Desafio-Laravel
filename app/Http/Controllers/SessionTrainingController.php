<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Employee;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SessionTrainingController extends Controller
{
    public function index(): View
    {
        $trainings = SessionTraining::with('instructor')->get();
        $instructors = Employee::all();

        return view('sessionTraining', compact('trainings', 'instructors'));
    }

    public function store(Request $request)
    {
        try {
            SessionTraining::create([
                'instructor_id' => $request->instructor_id,
                'title' => $request->title,
                'description' => $request->description,
                'scheduled' => Carbon::parse($request->scheduled),
                'class_amount' => $request->class_amount,
                'class_min' => $request->class_min,
                'validity_dt' => $request->validity_dt,
                'status' => 'Agendado',
            ]);

            return redirect()->back()->with('Success', 'Aula agendada com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao agendar a aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível agendar a aula.');
        }
    }

    public function editView(SessionTraining $training): View
    {
        $instructors = Employee::all();
        $classes = $training->classes()->orderBy('class_dt')->get();

        return view('editSessionTraining', compact('training', 'instructors', 'classes'));
    }

    public function update(Request $request, SessionTraining $training)
    {
        try {
            $training->update([
                'instructor_id' => $request->instructor_id,
                'title' => $request->title,
                'description' => $request->description,
                'scheduled' => Carbon::parse($request->scheduled),
                'class_amount' => $request->class_amount,
                'class_min' => $request->class_min,
                'validity_dt' => $request->validity_dt,
                'status' => $request->status,
            ]);

            return redirect(route('training.viewUpdate', $training->id))->with('Success', 'Aula atualizada com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar a aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível atualizar a aula.');
        }
    }

    public function storeClass(Request $request, SessionTraining $training)
    {
        try {
            Classes::create([
                'session_training_id' => $training->id,
                'class_dt' => $request->class_dt,
            ]);

            return redirect()->back()->with('Success', 'Data de aula adicionada com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao adicionar data de aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível adicionar a data de aula.');
        }
    }

    public function destroyClass(SessionTraining $training, Classes $class)
    {
        try {
            $class->delete();

            return redirect()->back()->with('Success', 'Data de aula removida com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao remover data de aula: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível remover a data de aula.');
        }
    }
}
