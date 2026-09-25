<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $grouped = Permission::all()->groupBy(function ($permissions) {
            return explode(' ', $permissions->name, 2)[0];
        });
        $positions = UserRole::with('rolePermissions')->get();

        return view('position', compact('positions', 'grouped'));
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
            $userRole = UserRole::create([
                'title' => $request->title,
                'status' => 'Ativo',
            ]);

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'permission_')) {
                    RolePermission::create([
                        'user_role_id' => $userRole->id,
                        'permission_id' => intval($value),
                    ]);
                }
            }

            return redirect()->back()->with('Success', 'Cargo criado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro na criação do cargo: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível criar o cargo.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $userRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRole $userRole)
    {
        try {
            $userRole->update([
                'title' => $request->title,
            ]);

            $userRole->rolePermissions()->delete();

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'permission_')) {
                    RolePermission::create([
                        'user_role_id' => $userRole->id,
                        'permission_id' => intval($value),
                    ]);
                }
            }

            return redirect()->back()->with('Success', 'Cargo atualizado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro na atualização do cargo: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível atualizar o cargo.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $userRole)
    {
        //
    }
}
