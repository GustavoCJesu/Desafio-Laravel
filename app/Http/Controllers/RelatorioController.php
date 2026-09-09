<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RelatorioController extends Controller {
    public function index(): View{

        if(Auth::check()){
            return view('relatorios');
        }else {
            return view('login', ['error'=> 'Você precisa estar conectado a uma conta para acessar esta pagina.']);
        }
    }
}
