<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\Abono;
use App\Models\PagoUsuario;
use Illuminate\Http\Request;
use App\Models\TasaUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AbonoController extends Controller
{
    public function nuevoAbono(Request $request)
    {
        // Validación de entrada
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

        $importe = $request->input('inputImporte');
        $pagoUsuarioId = $request->input('InputPagoUsuarioId');

        // Calcular deuda pendiente
        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
            )
            ->where('pp.id', $pagoUsuarioId)
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $deudaPendiente = round($pagosConAbonos->Deuda - $pagosConAbonos->Abonado, 2);
        $importe = round($importe, 2);

        // Validación del abono (permitir completar exactamente la deuda)
        dd($importe - $deudaPendiente);
        if ($importe - $deudaPendiente > 0.01) {
            return redirect()->back()->with('error', 'El abono excede la deuda pendiente.');
        }

        // Obtener tasas
        $tasaSeleccionada = TasaUsuario::findOrFail($request->input('inputAnioPago'));
        $anio = $tasaSeleccionada->anio;

        $tasaAdministracion = TasaUsuario::where('anio', $anio)->where('tipo', 1)->first();
        $tasaBienestar = TasaUsuario::where('anio', $anio)->where('tipo', 2)->first();

        $tasaAdmonPago = round($importe * ($tasaAdministracion->tasa / 100), 2);
        $tasaBienestarPago = round($importe * ($tasaBienestar->tasa / 100), 2);

        // Crear abono
        $abono = new Abono();
        $abono->pagoUsuario_id = $pagoUsuarioId;
        $abono->anio_pago = $request->input('inputAnioPago');
        $abono->importe = $importe;
        $abono->tasa_administracion = $tasaAdmonPago;
        $abono->tasa_bienestar = $tasaBienestarPago;
        $abono->factura = '';
        $abono->save();

        // Guardar factura
        $factura = $request->file("inputFactura");
        $fecha = now()->format('YmdHis');
        $idAbono = str_pad($abono->id, 4, '0', STR_PAD_LEFT);
        $extension = $factura->getClientOriginalExtension();
        $facturaNombre = "abono_{$fecha}_{$pagoUsuarioId}_{$idAbono}.{$extension}";
        $factura->storeAs('public/facturas', $facturaNombre);

        $abono->factura = $facturaNombre;
        $abono->save();

        // Actualizar estado del pago si se completa la deuda
        $totalAbonado = round($pagosConAbonos->Abonado + $importe, 2);
        if ($totalAbonado >= $pagosConAbonos->Deuda) {
            PagoUsuario::where('id', $pagoUsuarioId)->update(['estadoPago' => 'Completo']);
        }

        return redirect()->back()->with('success', 'Abono registrado correctamente.');
    }







    public function editar(Abono $abono)
    {
        $pago = $abono->pagoUsuario_id;
        $usuario = PagoUsuario::where('id', $pago)->value('usuario_id');
        $tasas = TasaUsuario::select('id', 'anio', 'tipo', 'tasa')
            ->orderBy('anio')
            ->get()
            ->groupBy('anio');
        return view('procesos.pagoUsuarios.editarAbono', compact('abono', 'usuario', 'tasas', 'pago'));
    }


    public function updateAbono(Request $request, Abono $abono)
    {
        $request->validate([
            'inputAnioPago' => 'required|exists:tasas_usuarios,id',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'nullable|mimes:pdf|max:2048'
        ], [
            'inputAnioPago.required' => 'Debe seleccionar un año de abono.',
            'inputAnioPago.exists' => 'El año seleccionado no es válido.',
            'inputImporte.required' => 'El campo "Importe" es obligatorio.',
            'inputImporte.numeric' => 'El "Importe" debe ser un número.',
            'inputFactura.mimes' => 'La factura debe estar en formato PDF.',
            'inputFactura.max' => 'La factura no debe superar los 2MB.'
        ]);

        $pagoUsuarioId = $abono->pagoUsuario_id;

        // Calcular deuda pendiente excluyendo el abono actual
        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
            )
            ->where('pp.id', $pagoUsuarioId)
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $deudaPendiente = $pagosConAbonos->Deuda - ($pagosConAbonos->Abonado - $abono->importe);

        if ($request->input('inputImporte') > $deudaPendiente) {
            return redirect()->back()->with('error', 'El abono excede la deuda pendiente.');
        }

        // Actualizar importe y tasas
        $importe = $request->input('inputImporte');
        $tasaSeleccionada = TasaUsuario::findOrFail($request->input('inputAnioPago'));
        $anio = $tasaSeleccionada->anio;

        $tasaAdministracion = TasaUsuario::where('anio', $anio)->where('tipo', 1)->first();
        $tasaBienestar = TasaUsuario::where('anio', $anio)->where('tipo', 2)->first();

        $abono->anio_pago = $request->input('inputAnioPago');
        $abono->importe = $importe;
        $abono->tasa_administracion = $importe * ($tasaAdministracion->tasa / 100);
        $abono->tasa_bienestar = $importe * ($tasaBienestar->tasa / 100);

        // Manejo de factura si se sube un nuevo archivo
        if ($request->hasFile('inputFactura')) {
            $factura = $request->file('inputFactura');
            if ($abono->factura && Storage::exists('public/facturas/' . $abono->factura)) {
                Storage::delete('public/facturas/' . $abono->factura);
            }
            $fecha = now()->format('YmdHis');
            $pagoId = str_pad($abono->pagoUsuario_id, 2, '0', STR_PAD_LEFT);
            $extension = $factura->getClientOriginalExtension();
            $facturaNombre = "abono_{$fecha}_{$pagoId}.{$extension}";
            $factura->storeAs('public/facturas', $facturaNombre);
            $abono->factura = $facturaNombre;
        }

        $abono->save();

        // 🔹 Recalcular deuda total después de la actualización
        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
            )
            ->where('pp.id', $pagoUsuarioId)
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $deudaPendienteFinal = $pagosConAbonos->Deuda - $pagosConAbonos->Abonado;

        // 🔹 Actualizar estado del pago según la deuda pendiente
        if ($deudaPendienteFinal <= 0) {
            PagoUsuario::where('id', $pagoUsuarioId)->update(['estadoPago' => 'Completo']);
        } else {
            PagoUsuario::where('id', $pagoUsuarioId)->update(['estadoPago' => 'Pendiente']);
        }

        $usuarioId = PagoUsuario::where('id', $pagoUsuarioId)->value('usuario_id');

        return redirect("/pagos/detalle/abonos/{$usuarioId}/{$pagoUsuarioId}")
            ->with('success', 'Abono actualizado correctamente.');
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

    public function destroy($id)
    {
        $abono = Abono::findOrFail($id);
        $pagoUsuarioId = $abono->pagoUsuario_id;

        try {
            // Eliminar el archivo de la factura si existe
            if ($abono->factura && Storage::exists('public/facturas/' . $abono->factura)) {
                Storage::delete('public/facturas/' . $abono->factura);
            }

            // Eliminar el registro de la base de datos
            $abono->delete(); // Las relaciones con `onDelete('cascade')` se respetan

            // 🔹 Recalcular deuda total después de la eliminación
            $pagosConAbonos = DB::table('pagos_usuarios as pp')
                ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
                ->select(
                    'pp.importe as Deuda',
                    DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
                )
                ->where('pp.id', $pagoUsuarioId)
                ->groupBy('pp.id', 'pp.importe')
                ->first();

            $deudaPendiente = $pagosConAbonos ? $pagosConAbonos->Deuda - $pagosConAbonos->Abonado : 0;

            // 🔹 Actualizar estado del pago según la deuda pendiente
            if ($deudaPendiente <= 0) {
                PagoUsuario::where('id', $pagoUsuarioId)->update(['estadoPago' => 'Completo']);
            } else {
                PagoUsuario::where('id', $pagoUsuarioId)->update(['estadoPago' => 'Pendiente']);
            }

            return redirect()->back()->with('success', 'Abono eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el abono. Asegúrese de que no tenga registros relacionados.');
        }
    }
}
