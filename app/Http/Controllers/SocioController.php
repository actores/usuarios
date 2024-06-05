<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;

class SocioController extends Controller
{
    public function buscarIdentificacion(Request $request){
        $data_buscar = $request->data_buscar;
        $socios = Socio::where('identificacion', 'like', '%'.$data_buscar.'%')->get();
        // $socios->appends(['data_buscar' => $data_buscar]);

        return view('areas.socios.repertorio')->with('socios', $socios);
    }

}
