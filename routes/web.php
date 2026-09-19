<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticated'])->name('login');

Route::middleware('auth')->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    Route::post('/change-status', [EmployeeController::class, 'change_status'])->name('employees.change');
    Route::post('/employees/create', [EmployeeController::class, 'store'])->name('employees.create');

    Route::get('/employees/update/{id}/edit', [EmployeeController::class, 'editView'])->name('employees.viewUpdate');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');

    Route::post('/employee/user/create', [UserController::class, 'store'])->name('user.create');
    Route::put('/employee/user/edit/{id}', [UserController::class, 'update'])->name('user.update');

});
