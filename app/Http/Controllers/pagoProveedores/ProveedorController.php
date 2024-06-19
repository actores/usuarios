<?php

namespace App\Http\Controllers\pagoProveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\PagoProveedor;
use App\Models\TipoProveedor;

class ProveedorController extends Controller
{
    public function listarProveedores(Request $request){
        $proveedores = Proveedor::all();
        $tiposProveedor = TipoProveedor::all();
        return view('procesos.pagoUsuarios.proveedores')->with('proveedores', $proveedores)->with('tiposProveedor', $tiposProveedor);
    }

    public function nuevoProveedor(Request $request){
        $request->validate([
            'inputNombre' => 'required',
            'inputTipoProveedor' => 'required|numeric',
            'inputNit' => 'required|numeric',
            'inputDireccion' => 'required|string',
            'inputCiudad' => 'required|string',
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombre = $request->input('inputNombre'); 
        $proveedor->tipo_id = $request->input('inputTipoProveedor');
        $proveedor->nit = $request->input('inputNit');
        $proveedor->direccion = $request->input('inputDireccion');
        $proveedor->ciudad = $request->input('inputCiudad');
        $proveedor->save();

        return redirect()->back()->with('success', 'Proveedor registrado correctamente.');
    }

    public function detalleProveedor($id){
        $proveedor = Proveedor::find($id);
        $pagos = PagoProveedor::where('proveedor_id',$id)->get();
        return view('procesos.pagoUsuarios.detalleProveedor')->with('proveedor', $proveedor)->with('pagos',$pagos);
    }
}
