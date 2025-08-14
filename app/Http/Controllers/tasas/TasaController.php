<?php

namespace App\Http\Controllers\tasas;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\TasaUsuario;
use Illuminate\Http\Request;
use App\Exports\TasasExport;
use Maatwebsite\Excel\Facades\Excel;

class TasaController extends Controller
{
    public function listarTasas(Request $request)
    {
        // Capturamos el valor del buscador (del input "buscar")
        $buscar = $request->input('buscar');

        // Creamos la consulta base
        $query = TasaUsuario::query();

        // Si hay algo en el buscador, filtramos por año o tasa
        if ($buscar) {
            $query->where('anio', 'like', "%{$buscar}%")
                ->orWhere('tasa', 'like', "%{$buscar}%");
        }

        // Paginamos (26 por página)
        $tasas = $query->paginate(26);

        // Retornamos la vista con los datos y la búsqueda actual
        return view('procesos.tasas.index', compact('tasas', 'buscar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|min:2000',
            'tasa_admin' => 'required|numeric|min:0.01',
            'tasa_bienestar' => 'required|numeric|min:0.01',
        ]);

        TasaUsuario::create([
            'anio' => $request->anio,
            'tipo' => 1, // Administración
            'tasa' => $request->tasa_admin,
        ]);

        TasaUsuario::create([
            'anio' => $request->anio,
            'tipo' => 2, // Bienestar
            'tasa' => $request->tasa_bienestar,
        ]);

        return redirect()->route('tasas.listar')->with('success', 'Tasas creadas correctamente');
    }
    public function edit($anio)
    {
        $tasas = TasaUsuario::where('anio', $anio)->get();

        $admin = $tasas->firstWhere('tipo', 1);
        $bienestar = $tasas->firstWhere('tipo', 2);

        return view('procesos.tasas.edit', compact('anio', 'admin', 'bienestar'));
    }

    public function update(Request $request, $anio)
    {
        $request->validate([
            'tasa_admin' => 'required|numeric|min:0',
            'tasa_bienestar' => 'required|numeric|min:0',
        ], [
            'tasa_admin.required' => 'La tasa de administración es obligatoria.',
            'tasa_admin.numeric'  => 'La tasa de administración debe ser numérica.',
            'tasa_admin.min'      => 'La tasa de administración debe ser mayor o igual a 0.',

            'tasa_bienestar.required' => 'La tasa de bienestar es obligatoria.',
            'tasa_bienestar.numeric'  => 'La tasa de bienestar debe ser numérica.',
            'tasa_bienestar.min'      => 'La tasa de bienestar debe ser mayor o igual a 0.',
        ]);

        // 1️⃣ Guardar/actualizar tasas
        $tasaAdmin = TasaUsuario::updateOrCreate(
            ['anio' => $anio, 'tipo' => 1], // Administración
            ['tasa' => $request->tasa_admin]
        );

        $tasaBienestar = TasaUsuario::updateOrCreate(
            ['anio' => $anio, 'tipo' => 2], // Bienestar
            ['tasa' => $request->tasa_bienestar]
        );

        // 2️⃣ Obtener todos los abonos que corresponden a este año
        $abonos = Abono::whereIn('anio_pago', [$tasaAdmin->id, $tasaBienestar->id])->get();

        // 3️⃣ Recalcular las tasas en cada abono
        foreach ($abonos as $abono) {
            $importe = $abono->importe;

            $abono->tasa_administracion = $importe * ($tasaAdmin->tasa / 100);
            $abono->tasa_bienestar      = $importe * ($tasaBienestar->tasa / 100);
            $abono->save();
        }

        return redirect()->route('tasas.listar')
            ->with('success', 'Tasas y abonos actualizados correctamente.');
    }
    public function exportar(Request $request)
    {
        $buscar = $request->input('buscar');
        return Excel::download(new TasasExport($buscar), 'tasas.xlsx');
    }
}
