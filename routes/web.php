<?php

use App\Http\Controllers\CertificateController;
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
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index')->middleware('can:employees.view');
    Route::get('/employee/profile/{id}', [EmployeeController::class, 'show'])->name('employees.profile')->middleware('can:employees.view');

    Route::post('/change-status', [EmployeeController::class, 'toggleStatus'])->name('employees.change')->middleware('can:employees.update');
    Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employees.create')->middleware('can:employees.create');

    Route::get('/employees/update/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.viewUpdate')->middleware('can:employees.update');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware('can:employees.update');

    Route::post('/employee/user/create', [UserController::class, 'store'])->name('user.create')->middleware('can:employees.update');
    Route::put('/employee/user/edit/{id}', [UserController::class, 'update'])->name('user.update')->middleware('can:employees.update');

    Route::get('/positions', [PositionsController::class, 'index'])->name('position.index');
    Route::post('/position/create', [PositionsController::class, 'store'])->name('position.create');
    Route::put('/position/update/{userRole}', [PositionsController::class, 'update'])->name('position.update');
    Route::delete('/position/delete/{userRole}', [PositionsController::class, 'destroy'])->name('position.delete');

    Route::get('/epis', [EpiController::class, 'index'])->name('epi.index')->middleware('can:epis.view');
    Route::get('/epis/{epi}', [EpiController::class, 'show'])->name('epi.show')->middleware('can:epis.view');
    Route::put('/epis/{epi}', [EpiController::class, 'update'])->name('epi.update')->middleware('can:epis.update');
    Route::delete('/epi/delete/{id}', [EpiController::class, 'delete'])->name('epi.delete')->middleware('can:epis.delete');
    Route::post('/epi/create', [EpiController::class, 'store'])->name('epi.create')->middleware('can:epis.create');
    Route::post('epi/toggle/{epi}', [EpiController::class, 'toggle'])->name('epi.toggle')->middleware('can:epis.update');

    // Rotas para aulas
    Route::get('/aulas', [SessionTrainingController::class, 'index'])->name('training.index')->middleware('can:trainings.view');
    Route::post('/aulas/create', [SessionTrainingController::class, 'store'])->name('training.create')->middleware('can:trainings.create');
    Route::get('/aulas/{sessionTraining}/editar', [SessionTrainingController::class, 'edit'])->name('training.edit')->middleware('can:trainings.update');
    Route::delete('/aula/{sessionTraining}/excluir', [SessionTrainingController::class, 'destroy'])->name('training.delete')->middleware('can:trainings.delete');
    Route::post('/aula/{sessionTraining}/editar', [SessionTrainingController::class, 'update'])->name('training.update')->middleware('can:trainings.update');

    Route::get('/aula/{sessionTraining}/show', [SessionTrainingController::class, 'show'])->name('training.show')->middleware('can:trainings.view');

    Route::post('/aulas/{sessionTraining}/editar/vincularepi', [SessionTrainingController::class, 'vincEpi'])->name('training.vincepi')->middleware('can:trainings.update');
    Route::post('/aulas/{sessionTraining}/editar/criarAula', [SessionTrainingController::class, 'createClass'])->name('training.createclass')->middleware('can:trainings.update');
    Route::post('/aulas/{sessionTraining}/editar/concluirAula/{id}', [SessionTrainingController::class, 'completeClass'])->name('training.completeclass')->middleware('can:trainings.update');
    Route::post('/aulas/{sessionTraining}/editar/removerAula/{id}', [SessionTrainingController::class, 'deleteClass'])->name('training.deleteclass')->middleware('can:trainings.update');
    Route::post('/aula/{sessionTraining}/editar/vincEmployee', [SessionTrainingController::class, 'vincEMployee'])->name('training.vincemployee')->middleware('can:trainings.update');
    Route::post('/aula/{sessionTraining}/attendance/', [SessionTrainingController::class, 'attendanceSession'])->name('training.attendance')->middleware('can:trainings.update');

    // Telas com dados estáticos (protótipos de interface)
    Route::view('/painel', 'pages.dashboard')->name('dashboard');

    Route::get('/certificados', [CertificateController::class, 'index'])->name('certificate.index');
    Route::post('/cerificate/issue/{Session}', [CertificateController::class, 'store'])->name('certificate.store')->middleware('can:certificates.allow');

    Route::get('/relatorios', [ReportController::class, 'index'])->name('report.index')->middleware('can:reports.view');

});
