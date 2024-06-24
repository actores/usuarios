<?php

namespace App\Http\Controllers\pagoProveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\PagoProveedor;
use App\Models\TipoProveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function listarProveedores(Request $request)
    {
        // $proveedores = Proveedor::all();
        $proveedores = DB::table('proveedores')
            ->join('tipos_proveedor','proveedores.tipo_id', '=','tipos_proveedor.id')
            ->select('proveedores.*', 'tipos_proveedor.nombre as tipo_proveedor')
            ->get();

        // dd($proveedores);
        $tiposProveedor = TipoProveedor::all();
        return view('procesos.pagoUsuarios.proveedores')->with('proveedores', $proveedores)->with('tiposProveedor', $tiposProveedor);
    }

    public function nuevoProveedor(Request $request)
    {
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

    public function detalleProveedor($id)
    {
        $proveedor = DB::table('proveedores')
            ->join('tipos_proveedor','proveedores.tipo_id', '=','tipos_proveedor.id')
            ->select('proveedores.*', 'tipos_proveedor.nombre as tipo_proveedor')
            ->where('proveedores.id', $id) 
            ->first();

        // dd($proveedor);


        $pagos = PagoProveedor::with('abonos')
        ->select(
            'pagos_proveedores.id',
            'pagos_proveedores.proveedor_id',
            'pagos_proveedores.anio_explotacion',
            'pagos_proveedores.importe',
            'pagos_proveedores.factura',
            'pagos_proveedores.estadoPago',
            DB::raw('COALESCE(SUM(abonos.importe), 0) as total_abonos'),
            DB::raw('COALESCE((SUM(abonos.importe) / pagos_proveedores.importe) * 100, 0) as porcentaje_pago')
        )
        ->leftJoin('abonos', 'pagos_proveedores.id', '=', 'abonos.pagoProveedor_id')
        ->where('pagos_proveedores.proveedor_id', $id)
        ->groupBy(
            'pagos_proveedores.id',
            'pagos_proveedores.proveedor_id',
            'pagos_proveedores.anio_explotacion',
            'pagos_proveedores.importe',
            'pagos_proveedores.factura',
            'pagos_proveedores.estadoPago'
        )
        ->get();

        return view('procesos.pagoUsuarios.detalleProveedor')->with('proveedor', $proveedor)->with('pagos', $pagos);
    }
}
