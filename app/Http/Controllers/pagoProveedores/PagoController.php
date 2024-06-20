<?php

namespace App\Http\Controllers\pagoProveedores;

use App\Http\Controllers\Controller;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use App\Models\PagoProveedor;
use App\Models\Proveedor;

class PagoController extends Controller
{
    public function nuevoPago(Request $request){
        $request->validate([
            'inputAnioExplotacion' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'required|mimes:pdf|max:2048',
            'inputEstadoPago' => 'required|string'
        ]);

        $factura = $request->file("inputFactura");
        $faturaNombre = time().'_'. $factura->getClientOriginalName();

        
        $factura->storeAs('public/facturas', $faturaNombre);

        $pago = new PagoProveedor();
        $pago->proveedor_id = $request->input("InputProveedorId");
        $pago->anio_explotacion = $request->input("inputAnioExplotacion");
        $pago->importe = $request->input("inputImporte");
        $pago->factura = $faturaNombre;
        $pago->estadoPago = $request->input("inputEstadoPago");
        $pago->save();

        return redirect()->back()->with('success', 'Pago registrado correctamente.');
    }

   
}
