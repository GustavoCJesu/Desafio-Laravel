<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EpiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\positionsController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticated'])->name('login');

Route::middleware('auth')->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employee/profile/{id}', [EmployeeController::class, 'showProfile'])->name('employees.profile');

    Route::post('/change-status', [EmployeeController::class, 'change_status'])->name('employees.change');
    Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employees.create');

    Route::get('/employees/update/{id}/edit', [EmployeeController::class, 'editView'])->name('employees.viewUpdate');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');

    Route::post('/employee/user/create', [UserController::class, 'store'])->name('user.create');
    Route::put('/employee/user/edit/{id}', [UserController::class, 'update'])->name('user.update');

    Route::get('/positions', [positionsController::class, 'index'])->name('position.index');
    Route::post('/position/create', [positionsController::class, 'store'])->name('position.create');
    Route::put('/position/update/{userRole}', [positionsController::class, 'update'])->name('position.update');

    Route::get('/epis', [EpiController::class, 'index'])->name('epi.index');
    Route::get('/epis/{id}', [EpiController::class, 'show'])->name('epi.show');
    Route::put('/epis/{id}', [EpiController::class, 'update'])->name('epi.update');

    Route::post('/epi/create', [EpiController::class, 'store'])->name('epi.create');

    // Telas com dados estáticos (protótipos de interface)
    Route::view('/painel', 'dashboard')->name('dashboard');
    Route::view('/aulas', 'trainings')->name('training.index');
    Route::view('/certificados', 'certificates')->name('certificate.index');
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('report.index');

});
