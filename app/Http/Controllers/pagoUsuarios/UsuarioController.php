<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\PagoUsuario;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function listarUsuarios(Request $request)
    {
        $buscar = $request->input('buscar');

        $usuarios = DB::table('usuarios')
            ->join('tipos_usuarios', 'usuarios.tipo_id', '=', 'tipos_usuarios.id')
            ->select('usuarios.*', 'tipos_usuarios.nombre as tipo_usuarios')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('usuarios.nombre', 'like', "%$buscar%")
                        ->orWhere('usuarios.nit', 'like', "%$buscar%")
                        ->orWhere('usuarios.razonSocial', 'like', "%$buscar%");
                });
            })
            ->paginate(10)
            ->appends(['buscar' => $buscar]); // para mantener el término en la paginación

        $tiposUsuario = TipoUsuario::all();

        return view('procesos.pagoUsuarios.usuarios', compact('usuarios', 'tiposUsuario'));
    }


    public function nuevoUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputNombre' => 'required',
            'inputRazonSocial' => 'required',
            'inputTipoUsuario' => 'required|numeric',
            'inputNit' => 'required|numeric|unique:usuarios,nit',
            'inputDireccion' => 'required|string',
            'inputCiudad' => 'required|string',
        ], [
            'inputNit.unique' => 'Ya existe un usuario registrado con ese NIT.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usuario = new Usuario();
        $usuario->nombre = $request->input('inputNombre');
        $usuario->razonSocial = $request->input('inputRazonSocial');
        $usuario->tipo_id = $request->input('inputTipoUsuario');
        $usuario->nit = $request->input('inputNit');
        $usuario->direccion = $request->input('inputDireccion');
        $usuario->ciudad = $request->input('inputCiudad');
        $usuario->save();

        return redirect()->route('usuarios.listar')->with('success', 'Usuario registrado correctamente.');
    }



    public function actualizarUsuario(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'inputNombre' => 'required',
            'inputRazonSocial' => 'required',
            'inputTipoUsuario' => 'required|numeric',
            'inputNit' => 'required|numeric|unique:usuarios,nit,' . $usuario->id,
            'inputDireccion' => 'required|string',
            'inputCiudad' => 'required|string',
        ], [
            'inputNombre.required' => 'El nombre es obligatorio.',
            'inputRazonSocial.required' => 'La razón social es obligatorio.',
            'inputTipoUsuario.required' => 'Debe seleccionar un tipo de usuario.',
            'inputTipoUsuario.numeric' => 'El tipo de usuario debe ser un valor numérico.',
            'inputNit.required' => 'El NIT es obligatorio.',
            'inputNit.numeric' => 'El NIT debe ser un valor numérico.',
            'inputNit.unique' => 'Ya existe otro usuario registrado con ese NIT.',
            'inputDireccion.required' => 'La dirección es obligatoria.',
            'inputDireccion.string' => 'La dirección debe ser un texto válido.',
            'inputCiudad.required' => 'La ciudad es obligatoria.',
            'inputCiudad.string' => 'La ciudad debe ser un texto válido.',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usuario->nombre = $request->input('inputNombre');
        $usuario->razonSocial = $request->input('inputRazonSocial');
        $usuario->tipo_id = $request->input('inputTipoUsuario');
        $usuario->nit = $request->input('inputNit');
        $usuario->direccion = $request->input('inputDireccion');
        $usuario->ciudad = $request->input('inputCiudad');
        $usuario->save();
        return redirect()->route('usuarios.detalle', ['id' => $usuario->id])->with('success', 'Usuario actualizado correctamente.');
    }



    public function detalleUsuario($id)
    {
        $usuario = DB::table('usuarios')
            ->join('tipos_usuarios', 'usuarios.tipo_id', '=', 'tipos_usuarios.id')
            ->select('usuarios.*', 'tipos_usuarios.nombre as tipo_usuario')
            ->where('usuarios.id', $id)
            ->first();

        $pagos = PagoUsuario::with('abonos')
            ->select(
                'pagos_usuarios.id',
                'pagos_usuarios.usuario_id',
                'pagos_usuarios.anio_explotacion',
                'pagos_usuarios.importe',
                'pagos_usuarios.factura',
                'pagos_usuarios.estadoPago',
                DB::raw('COALESCE(SUM(abonos.importe), 0) as total_abonos'),
                DB::raw('COALESCE((SUM(abonos.importe) / pagos_usuarios.importe) * 100, 0) as porcentaje_pago')
            )
            ->leftJoin('abonos', 'pagos_usuarios.id', '=', 'abonos.pagoUsuario_id')
            ->where('pagos_usuarios.usuario_id', $id)
            ->groupBy(
                'pagos_usuarios.id',
                'pagos_usuarios.usuario_id',
                'pagos_usuarios.anio_explotacion',
                'pagos_usuarios.importe',
                'pagos_usuarios.factura',
                'pagos_usuarios.estadoPago'
            )
            ->get();

        $tiposUsuario = TipoUsuario::all();

        // dd($usuario,$pagos );

        return view('procesos.pagoUsuarios.detalleUsuario', compact('usuario', 'pagos', 'tiposUsuario'));
    }
}
