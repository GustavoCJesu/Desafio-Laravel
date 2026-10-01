<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EpiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionTrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticated'])->name('login');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employee/profile/{id}', [EmployeeController::class, 'show'])->name('employees.profile');

    Route::post('/change-status', [EmployeeController::class, 'toggleStatus'])->name('employees.change');
    Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employees.create');

    Route::get('/employees/update/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.viewUpdate');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');

    Route::post('/employee/user/create', [UserController::class, 'store'])->name('user.create');
    Route::put('/employee/user/edit/{id}', [UserController::class, 'update'])->name('user.update');

    Route::get('/positions', [PositionsController::class, 'index'])->name('position.index');
    Route::post('/position/create', [PositionsController::class, 'store'])->name('position.create');
    Route::put('/position/update/{userRole}', [PositionsController::class, 'update'])->name('position.update');
    Route::delete('/position/delete/{userRole}', [PositionsController::class, 'destroy'])->name('position.delete');

    Route::get('/epis', [EpiController::class, 'index'])->name('epi.index');
    Route::get('/epis/{epi}', [EpiController::class, 'show'])->name('epi.show');
    Route::put('/epis/{epi}', [EpiController::class, 'update'])->name('epi.update');
    Route::delete('/epi/delete/{id}', [EpiController::class, 'delete'])->name('epi.delete');
    Route::post('/epi/create', [EpiController::class, 'store'])->name('epi.create');
    Route::post('epi/toggle/{epi}', [EpiController::class, 'toggle'])->name('epi.toggle');

    // Rotas para aulas
    Route::get('/aulas', [SessionTrainingController::class, 'index'])->name('training.index');
    Route::post('/aulas/create', [SessionTrainingController::class, 'store'])->name('training.create');
    Route::get('/aulas/{sessionTraining}/editar', [SessionTrainingController::class, 'edit'])->name('training.edit');
    Route::post('/aula/{sessionTraining}/editar', [SessionTrainingController::class, 'update'])->name('training.update');

    Route::get('/aula/{sessionTraining}/show', [SessionTrainingController::class, 'show'])->name('training.show');

    Route::post('/aulas/{sessionTraining}/editar/vincularepi', [SessionTrainingController::class, 'vincEpi'])->name('training.vincepi');
    Route::post('/aulas/{sessionTraining}/editar/criarAula', [SessionTrainingController::class, 'createClass'])->name('training.createclass');
    Route::post('/aulas/{sessionTraining}/editar/removerAula/{id}', [SessionTrainingController::class, 'deleteClass'])->name('training.deleteclass');
    Route::post('/aula/{sessionTraining}/editar/vincEmployee', [SessionTrainingController::class, 'vincEMployee'])->name('training.vincemployee');

    // Telas com dados estáticos (protótipos de interface)
    Route::view('/painel', 'pages.dashboard')->name('dashboard');

    Route::view('/certificados', 'pages.certificates.index')->name('certificate.index');
    Route::get('/relatorios', [ReportController::class, 'index'])->name('report.index');

});
