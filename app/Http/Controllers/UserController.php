<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(UserRequest $request)
    {
        try {
            User::create([
                'employee_id' => intval($request->employee_id),
                'user_role_id' => intval($request->user_role_id),
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return redirect(route('employees.viewUpdate', ['id' => $request->employee_id]))
                ->with('Success', 'Usuário criado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro na criação do usuario: '.$e->getMessage());

            return redirect(route('employees.viewUpdate', ['id' => $request->employee_id]))
                ->with('Error', 'Não foi possível criar o usuário.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->update([
                'user_role_id' => intval($request->user_role_id),
            ]);
            $user->save();

            return redirect()->back()->with('Success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro na edição do usuario: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível editar o usuário.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
