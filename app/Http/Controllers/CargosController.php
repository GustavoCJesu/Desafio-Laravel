<?php

namespace App\Http\Controllers;

use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CargosController extends Controller
{
    public function index(): View
    {

        $cargos = CompanyRole::all();
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0];
        });
        $users = User::all();
        $employees = Employee::all();

        return view('cargos', compact('cargos', 'permissions', 'users', 'employees'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);


        try {
            CompanyRole::create([
                'title' => $request->input('title'),
                'status' => 'Ativo',
            ]);
            // $table->id();
            // $table->string('title');
            // $table->string('status');
            // $table->timestamps();


            return redirect()->back()->with('success', 'Cargo criado com sucesso!');
        } catch (\Exception $e) {
            dd('Erro ao criar cargo: '.$e->getMessage());

            return redirect()->back()->with('error', 'Erro ao criar cargo: '.$e->getMessage());
        }
    }

    public function alter_status(Request $request)
    {

        $cargo = CompanyRole::find($request->id);
        if ($cargo) {
            $cargo->status = $cargo->status === 'Ativo' ? 'Inativo' : 'Ativo';
            $cargo->save();
        }

        return redirect()->back();
    }
}
