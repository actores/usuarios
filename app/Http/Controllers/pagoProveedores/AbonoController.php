<?php

namespace App\Http\Controllers\pagoProveedores;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\PagoProveedor;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function nuevoAbono(Request $request){
        $request->validate([
            'inputAnioPago' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'required|mimes:pdf|max:2048',
        ]);

        $factura = $request->file("inputFactura");
        $faturaNombre = time().'_'. $factura->getClientOriginalName();

        $factura->storeAs('public/facturas', $faturaNombre);

        $abono = new Abono();
        $abono->pagoProveedor_id = $request->input('InputPagoProveedorId');
        $abono->anio_pago = $request->input('inputAnioPago');
        $abono->importe = $request->input('inputImporte');
        $abono->factura = $faturaNombre;
        $abono->save();

        return redirect()->back()->with('success', 'Abono registrado correctamente.');

    }

    public function detalleAbono($idProveedor, $idPago){

        $proveedor = Proveedor::find($idProveedor);
        $pago = PagoProveedor::find($idPago);
        $detallesPago = Abono::where('pagoProveedor_id',$idPago)->get();


        return view('procesos.pagoUsuarios.detalleProveedorPago')
        ->with('proveedor', $proveedor)
        ->with('pago', $pago)
        ->with('detallesPago',$detallesPago);
    }
}
