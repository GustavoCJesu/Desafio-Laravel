<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;



Route::get('/', [RelatorioController::class, 'index'])->name('site.home');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticated'])->name('site.login');

Route::post('/logout', [LoginController::class, 'logout'])->name('site.logout')->middleware('auth');



