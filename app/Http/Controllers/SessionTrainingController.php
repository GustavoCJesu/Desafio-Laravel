<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Epi;
use App\Models\SessionTraining;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SessionTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $trainings = SessionTraining::get();
        $instructors = Employee::get();

        return view('pages.trainings.index', compact('trainings', 'instructors'));
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
    public function store(Request $request)
    {
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
    public function show(SessionTraining $sessionTraining)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionTraining $sessionTraining): View
    {
        $training = $sessionTraining->load(['epis', 'classes', 'employees']);
        $employees = Employee::with('sector')->where('status', 'Ativo')->orderBy('name')->get();
        $epis = Epi::with('category')->where('status', 'Ativo')->orderBy('name')->get();

        return view('pages.trainings.edit', compact('training', 'employees', 'epis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionTraining $sessionTraining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionTraining $sessionTraining)
    {
        //
    }
}
