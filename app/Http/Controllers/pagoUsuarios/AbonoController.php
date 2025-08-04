<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\PagoUsuario;
use Illuminate\Http\Request;
use App\Models\TasaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class AbonoController extends Controller
{
    public function nuevoAbono(Request $request)
    {
        $request->validate([
            'inputAnioPago' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'required|mimes:pdf|max:2048',
        ], [
            'inputAnioPago.required' => 'El campo "Año de pago" es obligatorio.',
            'inputAnioPago.numeric' => 'El "Año de pago" debe ser un número.',

            'inputImporte.required' => 'El campo "Importe" es obligatorio.',
            'inputImporte.numeric' => 'El "Importe" debe ser un número.',

            'inputFactura.required' => 'Debe adjuntar una factura en formato PDF.',
            'inputFactura.mimes' => 'La factura debe estar en formato PDF.',
            'inputFactura.max' => 'La factura no debe superar los 2MB de tamaño.',
        ]);

        $factura = $request->file("inputFactura");

        // Formato: fecha + ABONOUSUARIO + ID del pagoProveedor (2 dígitos)
        $pagoUsuarioId = str_pad($request->input('InputPagoUsuarioId'), 2, '0', STR_PAD_LEFT);
        $fecha = now()->format('Ymd');
        $extension = $factura->getClientOriginalExtension();
        $facturaNombre = "{$fecha}_ABONOUSUARIO_{$pagoUsuarioId}.{$extension}";

        $factura->storeAs('public/facturas', $facturaNombre);

        $tasaAbono = TasaUsuario::select('anio')->where('id', $request->input('inputAnioPago'))->first();

        $tasaAbonoAdministracion = TasaUsuario::where('anio', $tasaAbono->anio)
            ->where('tipo', 1)->first();

        $tasaAbonoBienestar = TasaUsuario::where('anio', $tasaAbono->anio)
            ->where('tipo', 2)->first();

        $tasaAbonoPagoAdministracion = $request->input('inputImporte') * ($tasaAbonoAdministracion->tasa / 100);
        $tasaAbonoPagoBienestar = $request->input('inputImporte') * ($tasaAbonoBienestar->tasa / 100);

        $abono = new Abono();
        $abono->pagoUsuario_id = $request->input('InputPagoUsuarioId');
        $abono->anio_pago = $request->input('inputAnioPago');
        $abono->importe = $request->input('inputImporte');
        $abono->tasa_administracion = $tasaAbonoPagoAdministracion;
        $abono->tasa_bienestar = $tasaAbonoPagoBienestar;
        $abono->factura = $facturaNombre;

        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.id as PagoID',
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado'),
                DB::raw('CASE 
                WHEN pp.importe = COALESCE(SUM(a.importe), 0) THEN 1 
                WHEN pp.importe < COALESCE(SUM(a.importe), 0) THEN 0 
                WHEN pp.importe > COALESCE(SUM(a.importe), 0) THEN 2 
             END as comparacion')
            )
            ->where('pp.id', $request->input('InputPagoUsuarioId'))
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $recuentoDeduda = ($pagosConAbonos->Deuda - $pagosConAbonos->Abonado) - $request->input('inputImporte');

        if ($recuentoDeduda < 0) {
            return redirect()->back()->with('error', 'El abono excede la deuda');
        } elseif ($recuentoDeduda == 0) {
            $abono->save();
            PagoUsuario::where('id', $request->input('InputPagoUsuarioId'))->update(['estadoPago' => 'Completo']);
            return redirect()->back()->with('success', 'Abono registrado correctamente.')->with('registrarAbono', 0);
        } else {
            $abono->save();
            return redirect()->back()->with('success', 'Abono registrado correctamente.');
        }
    }


    public function detalleAbono($idUsuario, $idPago)
    {
        $registrarAbono = 1;

        $usuario = Usuario::find($idUsuario);

        $pago = PagoUsuario::find($idPago);

        $recuentoAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
            )
            ->where('pp.id', $idPago)
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $totalPagado = $recuentoAbonos->Abonado;


        $tasas = TasaUsuario::select('id', 'anio', 'tipo', 'tasa')
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
            ->join('tasas_usuarios as tp', 'abonos.anio_pago', '=', 'tp.id')
            ->leftJoin('tasas_usuarios as t1', function ($join) {
                $join->on('tp.anio', '=', 't1.anio')
                    ->where('t1.tipo', '=', 1);
            })
            ->leftJoin('tasas_usuarios as t2', function ($join) {
                $join->on('tp.anio', '=', 't2.anio')
                    ->where('t2.tipo', '=', 2);
            })
            ->where('abonos.pagoUsuario_id', $idPago)
            ->get();


        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.id as PagoID',
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado'),
                DB::raw('CASE 
                    WHEN pp.importe = COALESCE(SUM(a.importe), 0) THEN 1 
                    WHEN pp.importe < COALESCE(SUM(a.importe), 0) THEN 0 
                    WHEN pp.importe > COALESCE(SUM(a.importe), 0) THEN 2 
                 END as comparacion')
            )
            ->where('pp.id', $idPago)
            ->groupBy('pp.id', 'pp.importe')
            ->first();


        $recuentoDeduda = ($pagosConAbonos->Deuda -  $pagosConAbonos->Abonado);

        if ($recuentoDeduda == 0) {
            $registrarAbono = 0;
        }


        return view('procesos.pagoUsuarios.detalleUsuarioPago')
            ->with('usuario', $usuario)
            ->with('pago', $pago)
            ->with('detallesPago', $detallesPago)
            ->with('tasas', $tasas)
            ->with('totalPagado', $totalPagado)
            ->with('registrarAbono', $registrarAbono);
    }
}
