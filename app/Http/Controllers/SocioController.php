<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;

class SocioController extends Controller
{
    public function listarSocios(Request $request)
    {

        $socios = Socio::paginate(10);
        return view('areas.socios.repertorio')->with('socios', $socios);
    }

    public function buscarIdentificacion(Request $request){
        $data_buscar = $request->data_buscar;

        $socios = Socio::where('nombre', 'like', '%' . $data_buscar . '%')->get();

        return view('areas.socios.repertorio')->with('socios', $socios);
    }
}
