<?php

namespace App\Http\Controllers\PagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use App\Exports\TiposUsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

class TipoUsuarioController extends Controller
{
    // 1️⃣ Listar tipos de usuario
    public function listarTiposUsuarios(Request $request)
    {
        $buscar = $request->input('buscar');

        $query = TipoUsuario::query();

        if ($buscar) {
            $query->where('nombre', 'like', "%{$buscar}%");
        }

        $tipos = $query->paginate(26);

        return view('procesos.usuarios.index', compact('tipos', 'buscar'));
    }

    // 2️⃣ Guardar nuevo tipo de usuario
    public function storeTipoUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:tipos_usuarios,nombre',
        ], [
            'nombre.required' => 'El nombre del tipo de usuario es obligatorio.',
            'nombre.unique' => 'Ya existe un tipo de usuario con este nombre.',
        ]);

        TipoUsuario::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipos_usuarios.listar')
            ->with('success', 'Tipo de usuario creado correctamente.');
    }

    // 3️⃣ Mostrar formulario de edición
    public function editTipoUsuario($id)
    {
        $tipo = TipoUsuario::findOrFail($id);
        return view('procesos.usuarios.edit', compact('tipo'));
    }

    // 4️⃣ Actualizar tipo de usuario
    public function updateTipoUsuario(Request $request, $id)
    {
        $tipo = TipoUsuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|unique:tipos_usuarios,nombre,' . $tipo->id,
        ], [
            'nombre.required' => 'El nombre del tipo de usuario es obligatorio.',
            'nombre.unique' => 'Ya existe un tipo de usuario con este nombre.',
        ]);

        $tipo->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('tipos_usuarios.listar')
            ->with('success', 'Tipo de usuario actualizado correctamente.');
    }

    public function exportarTiposUsuarios(Request $request)
    {
        $buscar = $request->input('buscar');

        return Excel::download(new TiposUsuariosExport($buscar), 'tipos_usuarios.xlsx');
    }
}
