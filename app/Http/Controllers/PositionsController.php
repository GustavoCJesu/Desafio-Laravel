<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Facades\Log;

class PositionsController extends Controller
{
    public function index()
    {

        $grouped = Permission::all()->groupBy(function ($permissions) {
            return explode(' ', $permissions->name, 2)[0];
        });
        $positions = UserRole::with('rolePermissions')->get();

        return view('pages.positions.index', compact('positions', 'grouped'));
    }

    public function store(PositionRequest $request)
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
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $userRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, UserRole $userRole)
    {
        try {
            $userRole->update([
                'title' => $request->title,
            ]);

            $permissionIds = collect($request->all())
                ->filter(fn ($value, $key) => str_starts_with($key, 'permission_'))
                ->map(fn ($value) => intval($value))
                ->values()
                ->all();

            $userRole->rolePermissions()->sync($permissionIds);

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
        $role = UserRole::findOrFail($userRole->id);

        if ($role->user()->exists()) {
            return redirect()->back()->with('Error', 'Não é possível deletar cargos que possuem pessoas vinculadas.');
        } else {
            $role->rolePermissions()->detach();
            $role->delete();

            return redirect()->back()->with('Success', 'Cargo deletado com sucesso');
        }
    }
}
