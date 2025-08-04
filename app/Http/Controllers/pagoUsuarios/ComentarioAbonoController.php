<?php

namespace App\Http\Controllers\pagoUsuarios;

use App\Http\Controllers\Controller;
use App\Models\ComentarioAbono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioAbonoController extends Controller
{
    // Método para obtener comentarios de un pago_usuario específico
    public function comentariosAbono($abonoId)
    {
        $comentarios = ComentarioAbono::with('usuario')
            ->where('abono_id', $abonoId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'abono_id' => 'required|integer|exists:abonos,id',  // Ajusta nombre tabla si es diferente
            'comentario' => 'required|string|max:1000',
        ]);

        // Crear el comentario
        $comentario = ComentarioAbono::create([
            'abono_id' => $request->abono_id,
            'comentario' => $request->comentario,
            'usuario_id' => Auth::id(),  // Asumiendo que el comentario pertenece al usuario autenticado
        ]);

        // Puedes devolver el comentario creado con usuario cargado
        $comentario->load('usuario'); // Asumiendo relación 'usuario' definida en modelo ComentarioPago

        return response()->json($comentario, 201);
    }
}
