<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use App\Models\PagoUsuario;
use App\Exports\PagoYAbonosExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PagoController extends Controller
{
    public function nuevoPago(Request $request)
    {
        $request->validate([
            'inputAnioExplotacion' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'required|mimes:pdf|max:2048'
        ], [
            'inputAnioExplotacion.required' => 'El campo "Año de explotación" es obligatorio.',
            'inputAnioExplotacion.numeric' => 'El "Año de explotación" debe ser un número.',
            'inputImporte.required' => 'El campo "Importe" es obligatorio.',
            'inputImporte.numeric' => 'El "Importe" debe ser un número.',
            'inputFactura.required' => 'Debe adjuntar una factura en formato PDF.',
            'inputFactura.mimes' => 'La factura debe estar en formato PDF.',
            'inputFactura.max' => 'La factura no debe superar los 2MB de tamaño.',
        ]);

        $factura = $request->file("inputFactura");

        // Crear el nuevo pago (sin aún asignar nombre de factura)
        $pago = new PagoUsuario();
        $pago->usuario_id = $request->input("InputUsuarioId");
        $pago->anio_explotacion = $request->input("inputAnioExplotacion");
        $pago->importe = $request->input("inputImporte");
        $pago->estadoPago = 'Pendiente';
        $pago->save();

        // Crear nombre del archivo con fecha + usuarioId + idPago
        $fecha = now()->format('Ymd');
        $usuarioId = str_pad($pago->usuario_id, 2, '0', STR_PAD_LEFT);
        $idPago = str_pad($pago->id, 4, '0', STR_PAD_LEFT);
        $extension = $factura->getClientOriginalExtension();
        $facturaNombre = "factura_{$fecha}_{$usuarioId}_{$idPago}.{$extension}";

        // Verificar si ya existe un archivo con ese nombre y eliminarlo
        $rutaFactura = "public/facturas/{$facturaNombre}";
        if (Storage::exists($rutaFactura)) {
            Storage::delete($rutaFactura);
        }

        // Guardar el archivo
        $factura->storeAs('public/facturas', $facturaNombre);

        // Actualizar el registro con el nombre de la factura
        $pago->factura = $facturaNombre;
        $pago->save();

        return redirect()->back()->with('success', 'Pago registrado correctamente.');
    }



    public function editar(PagoUsuario $pago)
    {
        $usuario = $pago->usuario; // Relación definida en el modelo
        return view('procesos.pagoUsuarios.editarPago', compact('pago', 'usuario'));
    }

    public function updatePago(Request $request, PagoUsuario $pago)
    {
        $request->validate([
            'inputAnioExplotacion' => 'required|numeric',
            'inputImporte' => 'required|numeric',
            'inputFactura' => 'nullable|mimes:pdf|max:2048'
        ]);

        $pago->anio_explotacion = $request->input("inputAnioExplotacion");
        $pago->importe = $request->input("inputImporte");

        // Si se subió una nueva factura
        if ($request->hasFile("inputFactura")) {
            $factura = $request->file("inputFactura");

            // Eliminar la factura anterior si existe
            if ($pago->factura && Storage::exists('public/facturas/' . $pago->factura)) {
                Storage::delete('public/facturas/' . $pago->factura);
            }

            // Generar nuevo nombre de factura
            $fecha = now()->format('Ymd');
            $usuarioId = str_pad($pago->usuario_id, 2, '0', STR_PAD_LEFT);
            $idPago = str_pad($pago->id, 4, '0', STR_PAD_LEFT);
            $extension = $factura->getClientOriginalExtension();
            $facturaNombre = "factura_{$fecha}_{$usuarioId}_{$idPago}.{$extension}";

            // Guardar el archivo
            $factura->storeAs('public/facturas', $facturaNombre);

            // Actualizar el campo factura
            $pago->factura = $facturaNombre;
        }

        $pago->save();

        // 🔹 Recalcular deuda total después de actualizar el pago
        $pagosConAbonos = DB::table('pagos_usuarios as pp')
            ->leftJoin('abonos as a', 'a.pagoUsuario_id', '=', 'pp.id')
            ->select(
                'pp.importe as Deuda',
                DB::raw('COALESCE(SUM(a.importe), 0) as Abonado')
            )
            ->where('pp.id', $pago->id)
            ->groupBy('pp.id', 'pp.importe')
            ->first();

        $deudaPendiente = $pagosConAbonos ? $pagosConAbonos->Deuda - $pagosConAbonos->Abonado : 0;

        // 🔹 Actualizar estado del pago según la deuda pendiente
        if ($deudaPendiente <= 0) {
            $pago->estadoPago = 'Completo';
        } else {
            $pago->estadoPago = 'Pendiente';
        }

        $pago->save();

        return redirect()->route('usuarios.detalle', $request->usuario_id)
            ->with('success', 'Pago actualizado correctamente.');
    }





    public function exportPagoConAbonos($id)
    {
        return Excel::download(new PagoYAbonosExport($id), 'pago_' . $id . '_abonos.xlsx');
    }

    public function destroy($id)
    {
        $pago = PagoUsuario::findOrFail($id);

        try {
            // Eliminar el archivo de la factura si existe
            if ($pago->factura && Storage::exists('public/facturas/' . $pago->factura)) {
                Storage::delete('public/facturas/' . $pago->factura);
            }

            // Eliminar el registro de la base de datos
            $pago->delete(); // Si hay relaciones con `onDelete('cascade')`, también se eliminarán

            return redirect()->back()->with('success', 'Pago eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el pago. Asegúrese de que no tenga registros relacionados.');
        }
    }
}
