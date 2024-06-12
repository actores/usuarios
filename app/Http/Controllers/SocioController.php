<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Produccion;

class SocioController extends Controller
{

    public function listarTotalSocios(){
        $socios = Socio::all();
        return view('areas.socios.repertorio')->with('socios', $socios);
    }

    public function detalleSocio($id){
        $socio = Socio::find($id);
        $producciones = Produccion::where('socio_id', $id)->get();
        return view('areas.socios.detalleSocio')->with('socio', $socio)->with('producciones', $producciones);
    }


    // public function buscarIdentificacion(Request $request){
    //     $data_buscar = $request->data_buscar;
    //     $socios = Socio::where('identificacion', 'like', '%'.$data_buscar.'%')->get();
    //     // $socios->appends(['data_buscar' => $data_buscar]);
       
    //     $producciones = Produccion::where('socio_id', $id)->get();

    //     return view('areas.socios.repertorio')->with('socios', $socios)->with('producciones', $producciones);
    // }

}
