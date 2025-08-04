<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\ComentarioPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioPagoController extends Controller
{
    // Método para obtener comentarios de un pago_usuario específico
    public function comentariosPorPago($pagoUsuarioId)
    {
        $comentarios = ComentarioPago::with('usuario')
            ->where('pagoUsuario_id', $pagoUsuarioId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'pagoUsuario_id' => 'required|integer|exists:pagos_usuarios,id',  // Ajusta nombre tabla si es diferente
            'comentario' => 'required|string|max:1000',
        ]);

        // Crear el comentario
        $comentario = ComentarioPago::create([
            'pagoUsuario_id' => $request->pagoUsuario_id,
            'comentario' => $request->comentario,
            'usuario_id' => Auth::id(),  // Asumiendo que el comentario pertenece al usuario autenticado
        ]);

        // Puedes devolver el comentario creado con usuario cargado
        $comentario->load('usuario'); // Asumiendo relación 'usuario' definida en modelo ComentarioPago

        return response()->json($comentario, 201);
    }
}
