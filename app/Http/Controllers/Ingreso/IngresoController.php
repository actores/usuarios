<?php

namespace App\Http\Controllers\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use App\Models\Socio;
use App\Models\Visitante;
use Illuminate\Http\Request;


class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::all();
        $socios = Socio::all();
        return view('procesos.ingreso.ingreso')->with('socios', $socios)->with('ingresos', $ingresos);
    }
    public function registrosocios(Request $request)
    {


        $data = [
            'socio_id' => $request->socioId, 
            'fecha' => $request->inputFechaIngreso, 
            'hora_entrada' => $request->inputHoraIngreso, 
            'area' => $request->inputAreaVisita, 
            'motivo' => $request->inputMotivoVisita, 
            'tipo' => 1 
        ];

        // Crear un nuevo ingreso
        $ingreso = Ingreso::create($data);
        session()->flash('success', 'Ingreso creado exitosamente.');
        return redirect()->route('ingreso');
    }
}
