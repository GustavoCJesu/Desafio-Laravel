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

    Route::middleware('can:positions.view')->group(function () {
        Route::get('/positions', [PositionsController::class, 'index'])->name('position.index');
    });

    Route::middleware('can:positions.create')->group(function () {
        Route::post('/position/create', [PositionsController::class, 'store'])->name('position.create');
    });

    Route::middleware('can:positions.update')->group(function () {
        Route::put('/position/update/{userRole}', [PositionsController::class, 'update'])->name('position.update');
    });

    Route::middleware('can:positions.delete')->group(function () {
        Route::delete('/position/delete/{userRole}', [PositionsController::class, 'destroy'])->name('position.delete');
    });

    Route::get('/certificados', [CertificateController::class, 'index'])->name('certificate.index');

    Route::middleware('can:employees.view')->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employee/profile/{id}', [EmployeeController::class, 'show'])->name('employees.profile');
    });

    Route::middleware('can:employees.create')->group(function () {
        Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employees.create');
    });

    Route::middleware('can:employees.update')->group(function () {
        Route::get('/employees/update/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.viewUpdate');
        Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::post('/change-status', [EmployeeController::class, 'toggleStatus'])->name('employees.change');
        Route::post('/employee/user/create', [UserController::class, 'store'])->name('user.create');
        Route::put('/employee/user/edit/{id}', [UserController::class, 'update'])->name('user.update');
    });

    Route::middleware('can:epis.view')->group(function () {
        Route::get('/epis', [EpiController::class, 'index'])->name('epi.index');
        Route::get('/epis/{epi}', [EpiController::class, 'show'])->name('epi.show');
    });

    Route::middleware('can:epis.create')->group(function () {
        Route::post('/epi/create', [EpiController::class, 'store'])->name('epi.create');
    });

    Route::middleware('can:epis.update')->group(function () {
        Route::put('/epis/{epi}', [EpiController::class, 'update'])->name('epi.update');
        Route::post('epi/toggle/{epi}', [EpiController::class, 'toggle'])->name('epi.toggle');
    });

    Route::middleware('can:epis.delete')->group(function () {
        Route::delete('/epi/delete/{id}', [EpiController::class, 'delete'])->name('epi.delete');
    });

    Route::middleware('can:trainings.view')->group(function () {
        Route::get('/aulas', [SessionTrainingController::class, 'index'])->name('training.index');
        Route::get('/aula/{sessionTraining}/show', [SessionTrainingController::class, 'show'])->name('training.show');
    });

    Route::middleware('can:trainings.create')->group(function () {
        Route::post('/aulas/create', [SessionTrainingController::class, 'store'])->name('training.create');
    });

    Route::middleware('can:trainings.update')->group(function () {
        Route::get('/aulas/{sessionTraining}/editar', [SessionTrainingController::class, 'edit'])->name('training.edit');
        Route::post('/aula/{sessionTraining}/editar', [SessionTrainingController::class, 'update'])->name('training.update');
        Route::post('/aulas/{sessionTraining}/editar/vincularepi', [SessionTrainingController::class, 'vincEpi'])->name('training.vincepi');
        Route::post('/aulas/{sessionTraining}/editar/criarAula', [SessionTrainingController::class, 'createClass'])->name('training.createclass');
        Route::post('/aulas/{sessionTraining}/editar/concluirAula/{id}', [SessionTrainingController::class, 'completeClass'])->name('training.completeclass');
        Route::post('/aulas/{sessionTraining}/editar/removerAula/{id}', [SessionTrainingController::class, 'deleteClass'])->name('training.deleteclass');
        Route::post('/aula/{sessionTraining}/editar/vincEmployee', [SessionTrainingController::class, 'vincEMployee'])->name('training.vincemployee');
        Route::post('/aula/{sessionTraining}/attendance/', [SessionTrainingController::class, 'attendanceSession'])->name('training.attendance');
    });

    Route::middleware('can:trainings.delete')->group(function () {
        Route::delete('/aula/{sessionTraining}/excluir', [SessionTrainingController::class, 'destroy'])->name('training.delete');
    });

    Route::middleware('can:certificates.allow')->group(function () {
        Route::post('/cerificate/issue/{sessionTraining}', [CertificateController::class, 'store'])->name('certificate.store');
    });

    Route::middleware('can:reports.view')->group(function () {
        Route::get('/relatorios', [ReportController::class, 'index'])->name('report.index');
    });

    Route::middleware('can:reports.create')->group(function () {
        Route::get('/relatorios/conformidade', [ReportController::class, 'compliance'])->name('report.compliance');
    });

    Route::middleware('can:reports.export')->group(function () {
        Route::get('/relatorios/conformidade/exportar', [ReportController::class, 'complianceExport'])->name('report.compliance.export');
    });

});
