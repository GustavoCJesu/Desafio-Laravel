<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EpiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\positionsController;
use App\Http\Controllers\SessionTrainingController;
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
    Route::get('/epis/{epi}', [EpiController::class, 'show'])->name('epi.show');
    Route::put('/epis/{epi}', [EpiController::class, 'update'])->name('epi.update');

    Route::get('/trainings', [SessionTrainingController::class, 'index'])->name('training.index');
    Route::post('/trainings/create', [SessionTrainingController::class, 'store'])->name('training.create');

    Route::get('/trainings/{training}/edit', [SessionTrainingController::class, 'editView'])->name('training.viewUpdate');
    Route::put('/trainings/{training}', [SessionTrainingController::class, 'update'])->name('training.update');
    Route::post('/trainings/{training}/classes', [SessionTrainingController::class, 'storeClass'])->name('training.classes.store');
    Route::delete('/trainings/{training}/classes/{class}', [SessionTrainingController::class, 'destroyClass'])->name('training.classes.destroy');

    Route::get('/trainings/{training}/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/trainings/{training}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::delete('/trainings/{training}/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::post('/trainings/{training}/epis', [AttendanceController::class, 'storeEpi'])->name('attendance.epis.store');
    Route::delete('/trainings/{training}/epis/{epi}', [AttendanceController::class, 'destroyEpi'])->name('attendance.epis.destroy');

    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificate.index');

});
