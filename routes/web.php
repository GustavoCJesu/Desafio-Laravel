<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/relatorios', [RelatorioController::class, 'index'])->name('site.home');
