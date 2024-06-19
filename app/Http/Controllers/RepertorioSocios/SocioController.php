<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Produccion;

class SocioController extends Controller
{

    public function listarTotalSocios()
    {
        $socios = Socio::all();
        return view('areas.socios.repertorio')->with('socios', $socios);
    }

    public function detalleSocio($id)
    {
        $socio = Socio::find($id);
        $producciones = Produccion::where('socio_id', $id)->get();
        return view('areas.socios.detalleSocio')->with('socio', $socio)->with('producciones', $producciones);
    }

    public function nuevoSocio(Request $request)
    {
        $request->validate([
            'inputIdentificacion' => 'required|numeric',
            'inputNombre' => 'required|string',
            'inputNumeroSocio' => 'required|numeric',
            'inputNumeroArtista' => 'required|numeric',
            'inputTipoSocio' => 'required',
            'inputFoto' => 'required|image|mimes:jpeg,png,jpg', // Validación para una imagen
        ]);


        // Procesar la foto
        if ($request->hasFile('inputFoto')) {
            $foto = $request->file('inputFoto');
            $rutaFoto = $foto->store('fotos', 'public');

            // Crear un nuevo socio con los datos del formulario y la ruta de la foto
            $socio = new Socio();
            $socio->identificacion = $request->input('inputIdentificacion');
            $socio->nombre = $request->input('inputNombre');
            $socio->numeroSocio = $request->input('inputNumeroSocio');
            $socio->numeroArtista = $request->input('inputNumeroArtista');
            $socio->tipoSocio = $request->input('inputTipoSocio');
            $socio->imagen = $rutaFoto; // Asignar la ruta de la foto aquí
            $socio->save();

            // Puedes retornar una respuesta de éxito, redirección, etc.
            return redirect()->back()->with('success', 'Socio registrado correctamente.');
        }

        // Manejo de error si no se pudo procesar la foto
        return redirect()->back()->with('error', 'Hubo un problema al registrar el socio.');
    }


    // public function buscarIdentificacion(Request $request){
    //     $data_buscar = $request->data_buscar;
    //     $socios = Socio::where('identificacion', 'like', '%'.$data_buscar.'%')->get();
    //     // $socios->appends(['data_buscar' => $data_buscar]);

    //     $producciones = Produccion::where('socio_id', $id)->get();

    //     return view('areas.socios.repertorio')->with('socios', $socios)->with('producciones', $producciones);
    // }

}
