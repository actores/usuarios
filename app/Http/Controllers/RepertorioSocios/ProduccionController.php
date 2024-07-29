<?php

namespace App\Http\Controllers\RepertorioSocios;

use App\Exports\ProduccionesExport;
use App\Exports\RepertorioExport;
use App\Exports\RepetorioIndividualExport;
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

    public function indexListarProducciones()
    {
        $producciones = Produccion::all();
        return view('procesos.repertorio.producciones')->with('producciones', $producciones);
    }

    public function vistaAgregarProduccion($id)
    {
        $socio = Socio::find($id);
        $producciones = Produccion::all();

        return view('procesos.repertorio.agregarProduccion')->with('socio', $socio)->with('producciones', $producciones);
    }

    public function agregarProduccionesRepertorio(Request $request)
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

    public function exportarRepertorio()
    {
        return Excel::download(new RepertorioExport, 'Repertorio.xlsx');
    }

    public function exportarRepertorioIndividual($id)
    {
        return Excel::download(new RepetorioIndividualExport($id), 'RepertorioIndividual.xlsx');
    }



    public function agregarProducciones(Request $request)
    {

        if ($request->operacion == 1) {

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'inputTituloObra' => 'required|string|max:255',
                'inputTipoProduccion' => 'required|string|max:255',
                'inputPais' => 'required',
                'inputAnio' => 'required|digits:4', // Se espera un año de 4 dígitos
                'inputDirector' => 'required|string|max:255',
            ]);

            // Crear una nueva instancia del modelo Produccion
            $produccion = new Produccion();

            // Asignar los valores desde el formulario a la nueva instancia
            $produccion->tituloObra = $validatedData['inputTituloObra'];
            $produccion->tipoProduccion = $validatedData['inputTipoProduccion'];
            $produccion->pais = $validatedData['inputPais'];
            $produccion->anio = $validatedData['inputAnio'];
            $produccion->director = $validatedData['inputDirector'];

            // Guardar la producción en la base de datos
            $produccion->save();
            $producciones = Produccion::all();

            return redirect()->route('producciones')
                ->with('success', 'Obra registrada correctamente.');
        } else if ($request->operacion == 2) {

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'inputTituloObra' => 'required|string|max:255',
                'inputTipoProduccion' => 'required|string|max:255',
                'inputPais' => 'required',
                'inputAnio' => 'required|digits:4', // Se espera un año de 4 dígitos
                'inputDirector' => 'required|string|max:255',
            ]);

            // Crear una nueva instancia del modelo Produccion
            $produccion = Produccion::find($request->inputProduccionId);

            // Asignar los valores desde el formulario a la nueva instancia
            $produccion->tituloObra = $validatedData['inputTituloObra'];
            $produccion->tipoProduccion = $validatedData['inputTipoProduccion'];
            $produccion->pais = $validatedData['inputPais'];
            $produccion->anio = $validatedData['inputAnio'];
            $produccion->director = $validatedData['inputDirector'];

            // Guardar la producción en la base de datos
            $produccion->save();
            $producciones = Produccion::all();

            return redirect()->route('producciones')
                ->with('success', 'Obra actualizada correctamente.');
        }
    }

    public function exportarProducciones()
    {
        return Excel::download(new ProduccionesExport(), 'Producciones.xlsx');
    }
}
