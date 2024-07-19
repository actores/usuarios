<?php

namespace App\Http\Controllers\RepertorioSocios;

use App\Exports\RepertorioExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\repertorioSocios\SocioController;
use App\Models\Produccion;
use App\Models\Socio;
use App\Models\SociosProduccion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProduccionController extends Controller
{
    public function listarProducciones()
    {
        $producciones = Produccion::all();
        return $producciones;
    }

    public function vistaAgregarProduccion($id)
    {
        $socio = Socio::find($id);
        $producciones = Produccion::all();

        return view('procesos.repertorio.agregarProduccion')->with('socio', $socio)->with('producciones', $producciones);
    }

    public function agregarProducciones(Request $request)
    {
        $socioId = $request->inputSocio;
        $produccionesNuevas = json_decode($request->inputNuevasProducciones);

        foreach ($produccionesNuevas as $produccion) {
            // Verificar si ya existe el registro
            $existingProduccion = SociosProduccion::where('socio_id', $socioId)
                ->where('produccion_id', $produccion->id)
                ->where('personaje', $produccion->character)
                ->first();

            if (!$existingProduccion) {
                // Crear el registro solo si no existe
                SociosProduccion::create([
                    'socio_id' => $socioId,
                    'produccion_id' => $produccion->id,
                    'personaje' => $produccion->character
                ]);
            }
        }

        $socio = Socio::find($socioId);

        return redirect()->action([SocioController::class, 'detalleSocio'], ['id' => $socio])
            ->with('mensaje', 'Producciones agregadas correctamente.');
    }


    public function editarPersonajeProduccion(Request $request)
    {

        SociosProduccion::where('socio_id', $request->socio_id)
            ->where('id', $request->produccion_id)
            ->update(['personaje' => $request->personaje_produccion]);

        return redirect()->action([SocioController::class, 'detalleSocio'], ['id' => $request->socio_id])
            ->with('mensaje', 'Personaje actualizado correctamente.');
    }

    public function eliminarProduccion($id)
    {

        // Buscar el usuario por ID
        $participacion = SociosProduccion::find($id);

        if ($participacion) {
            // Eliminar el usuario
            $participacion->delete();
            return redirect()->action([SocioController::class, 'detalleSocio'], ['id' => $participacion->socio_id])
            ->with('mensaje', 'Participación elimina correctamente.');
        } else {
            return redirect()->back()->with('error', 'Participación no encontrado');
        }
    }

    public function exportarRepertorio(){
        return Excel::download(new RepertorioExport,'Repertorio.xlsx');
    }
}
