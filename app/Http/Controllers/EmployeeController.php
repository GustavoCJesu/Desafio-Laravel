<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\CompanyRole;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {

        $employees = Employee::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->sector, function ($query, $sector) {
                $query->where('sector_id', $sector);
            })
            ->get();

        $search = $request->search;
        $sectors = Sector::whereHas('employee')->get();
        $roles = CompanyRole::whereHas('employee')->get();

        return view('employee', compact('employees', 'search', 'sectors', 'roles'));
    }

    public function editView(int $id): View
    {

        $employee = Employee::where('id', $id)->first();
        $sectors = Sector::all();
        $roles = CompanyRole::all();
        $user_roles = UserRole::all();

        $grouped = Permission::all()->groupBy(function ($permissions) {
            return explode(' ', $permissions->name, 2)[0];
        });

        $users = User::all();
        // dd($grouped);

        return view('editEmployee', compact('employee', 'sectors', 'roles', 'grouped', 'user_roles', 'users'));
    }

    public function update(EmployeeRequest $request, int $id)
    {

        $employee = Employee::findOrFail($id);

        try {
            $employee->update([
                'name' => $request->name,
                'cpf' => $request->cpf,
                'registration' => $request->registration,
                'sector_id' => $request->sector_id,
                'company_role_id' => $request->company_role_id,
            ]);
            $employee->save();

            return redirect(route('employees.viewUpdate', $id))->with('Success', 'Editado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar o funcionario: '.$e->getMessage());

            return redirect(route('employees.index'))->with('Error', 'Não foi possível atualizar o funcionário.');
        }
    }

    public function change_status(Request $request)
    {
        $employee = Employee::find($request->selected_employees);

        try {
            $employee->status = ($employee->status === 'Ativo') ? 'Inativo' : 'Ativo';
            $employee->save();

            return redirect()->back()->with('Success', 'Alteração feita com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro na alteração de status: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível fazer a alteração');
        }
    }

    public function store(EmployeeRequest $request)
    {
        try {
            Employee::create([
                'name' => $request->name,
                'company_role_id' => intval($request->company_role_id),
                'sector_id' => intval($request->sector_id),
                'registration' => Employee::generateRegistration(),
                'cpf' => $request->cpf,
                'hire_date' => $request->hire_date,
                'status' => 'Ativo',
            ]);

            return redirect()->back()->with('Success', 'Funcionário criado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro na criação do funcionário: '.$e->getMessage());

            return redirect()->back()->with('Error', 'Não foi possível criar o funcionário.');
        }
    }

    public function showProfile(int $id): View
    {

        $employee = Employee::findOrFail($id);

        return view('profile-employee', compact('employee'));
    }
}
