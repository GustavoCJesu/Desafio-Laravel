<?php

namespace App\Http\Controllers;

use App\Models\CompanyRole;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CargosController extends Controller
{
    public function index(): View{

    $cargos = CompanyRole::all();

    return view('cargos', compact('cargos'));
    }

    public function alter_status() {



    }

}
