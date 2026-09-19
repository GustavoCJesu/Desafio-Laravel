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
        // dd($request->all());
        try {
            User::create([
                'employee_id' => intval($request->employee_id),
                'user_role_id' => intval($request->user_role_id),
                'email' => $request->email,
                'password' => $request->password,
            ]);
        } catch (Exception $e) {
            Log::error('Erro na criação do usuario.', $e->getMessage());
        }

        return redirect(route('employees.viewUpdate', ['id' => $request->employee_id]));
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
            // dd($request->all());

            $user->update([
                'user_role_id' => intval($request->user_role_id)
            ]);
            $user->save();

            return redirect()->back()->with('Success', 'Usuario editado com sucesso!');

        } catch (Exception $e) {
            return redirect()->back()->with('Error', 'Não foipossivel editar o usuario.');
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
