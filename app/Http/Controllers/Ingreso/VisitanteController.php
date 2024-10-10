<?php

namespace App\Http\Controllers\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\Visitante;
use Illuminate\Http\Request;

class VisitanteController extends Controller
{
    public function vistaNuevoVisitante()
    {
        return view('procesos.visitantes.index');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'inputNombre' => 'required|string|max:255',
            'inputIdentificacion' => 'required|string|max:255|unique:visitantes,identificacion',
            'inputEmpresa' => 'nullable|string|max:255',
            'inputCargo' => 'nullable|string|max:255',
        ]);

        $visitante = Visitante::create([
            'nombre' => $validatedData['inputNombre'],
            'identificacion' => $validatedData['inputIdentificacion'],
            'empresa' => $validatedData['inputEmpresa'] ?? null,  // Opcional
            'cargo' => $validatedData['inputCargo'] ?? null,      // Opcional
        ]);

        session()->flash('success', 'Visitante, registrado correctamente');
        return redirect()->route('ingreso');
    }
}
