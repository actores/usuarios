<?php

namespace App\Http\Controllers\pagoProveedores;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\PagoProveedor;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Models\TasaProveedor;
use Illuminate\Support\Facades\DB;

class AbonoController extends Controller
{
    public function nuevoAbono(Request $request)
    {

        // return $request;
        $request->validate([
            'inputAnioPago' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'required|mimes:pdf|max:2048',
        ]);

        $factura = $request->file("inputFactura");
        $faturaNombre = time() . '_' . $factura->getClientOriginalName();

        $factura->storeAs('public/facturas', $faturaNombre);



        $tasaAbono = TasaProveedor::select('anio')->where('id', $request->input('inputAnioPago'))->first();


        $tasaAbonoAdministracion = TasaProveedor::where('anio', $tasaAbono->anio)
            ->where('tipo', 1)->first();



        $tasaAbonoBienestar = TasaProveedor::where('anio', $tasaAbono->anio)
            ->where('tipo', 2)->first();

        $tasaAbonoPagoAdministracion = $request->input('inputImporte') * ($tasaAbonoAdministracion->tasa / 100);
        $tasaAbonoPagoBienestar = $request->input('inputImporte') * ($tasaAbonoBienestar->tasa / 100);

        $abono = new Abono();
        $abono->pagoProveedor_id = $request->input('InputPagoProveedorId');
        $abono->anio_pago = $request->input('inputAnioPago');
        $abono->importe = $request->input('inputImporte');
        $abono->tasa_administracion = $tasaAbonoPagoAdministracion;
        $abono->tasa_bienestar = $tasaAbonoPagoBienestar;
        $abono->factura = $faturaNombre;
        $abono->save();

        return redirect()->back()->with('success', 'Abono registrado correctamente.');
    }

    public function detalleAbono($idProveedor, $idPago)
    {

        $proveedor = Proveedor::find($idProveedor);
        $pago = PagoProveedor::find($idPago);

        $tasas = TasaProveedor::select('id', 'anio', 'tipo', 'tasa')
            ->orderBy('anio')
            ->get()
            ->groupBy('anio');



        // $detallesPago = Abono::where('pagoProveedor_id', $idPago)->get();

        $detallesPago = Abono::select(
            'abonos.id',
            'tp.anio',
            'abonos.importe',
            'abonos.tasa_administracion',
            'abonos.tasa_bienestar',
            'abonos.factura',
            DB::raw('t1.tasa AS tasa_tipo1'),
            DB::raw('t2.tasa AS tasa_tipo2')
        )
            ->join('tasas_proveedor as tp', 'abonos.anio_pago', '=', 'tp.id')
            ->leftJoin('tasas_proveedor as t1', function ($join) {
                $join->on('tp.anio', '=', 't1.anio')
                    ->where('t1.tipo', '=', 1);
            })
            ->leftJoin('tasas_proveedor as t2', function ($join) {
                $join->on('tp.anio', '=', 't2.anio')
                    ->where('t2.tipo', '=', 2);
            })
            ->where('abonos.pagoProveedor_id', $idPago)
            ->get();



        return view('procesos.pagoUsuarios.detalleProveedorPago')
            ->with('proveedor', $proveedor)
            ->with('pago', $pago)
            ->with('detallesPago', $detallesPago)
            ->with('tasas', $tasas);
    }
}
