<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use App\Models\PagoUsuario;
use App\Exports\PagoYAbonosExport;
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

        // Obtener usuario_id y convertirlo a dos dígitos
        $usuarioId = str_pad($request->input("InputUsuarioId"), 2, '0', STR_PAD_LEFT);

        // Obtener la fecha actual en formato YYYYMMDD
        $fecha = now()->format('Ymd');

        // Obtener extensión del archivo (pdf)
        $extension = $factura->getClientOriginalExtension();

        // Construir el nombre del archivo
        $facturaNombre = "{$fecha}_PAGOUSUARIO_{$usuarioId}.{$extension}";

        // Guardar archivo en storage/app/public/facturas
        $factura->storeAs('public/facturas', $facturaNombre);

        // Crear el nuevo pago
        $pago = new PagoUsuario();
        $pago->usuario_id = $request->input("InputUsuarioId");
        $pago->anio_explotacion = $request->input("inputAnioExplotacion");
        $pago->importe = $request->input("inputImporte");
        $pago->factura = $facturaNombre;
        $pago->estadoPago = 'Pendiente';
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

    if ($request->hasFile("inputFactura")) {
        $factura = $request->file("inputFactura");

        $usuarioId = str_pad($pago->usuario_id, 2, '0', STR_PAD_LEFT);
        $fecha = now()->format('Ymd');
        $extension = $factura->getClientOriginalExtension();
        $facturaNombre = "{$fecha}_PAGOUSUARIO_{$usuarioId}.{$extension}";

        $factura->storeAs('public/facturas', $facturaNombre);
        $pago->factura = $facturaNombre;
    }

    $pago->save();

    // Redirigir al detalle del usuario
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
            $pago->delete(); // Esto también eliminará los abonos si tienes `onDelete('cascade')` en la relación
            return redirect()->back()->with('success', 'Pago eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el pago. Asegúrese de que no tenga registros relacionados.');
        }
    }
}
