<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('site.home');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticated'])->name('site.login');


Route::middleware('auth')->group(function(){

    Route::post('/logout', [LoginController::class, 'logout'])->name('site.logout');
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('site.relatorios');

});








