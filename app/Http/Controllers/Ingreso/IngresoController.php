<?php

namespace App\Http\Controllers\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use Illuminate\Http\Request;


class IngresoController extends Controller
{
    public function index(){
        $ingresos = Ingreso::all();
        return view('procesos.ingreso.ingreso')->with('ingresos', $ingresos);
    }
}
