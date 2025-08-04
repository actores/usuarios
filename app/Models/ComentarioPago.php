<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioPago extends Model
{
    use HasFactory;

    protected $table = 'comentarios_pagos';

    protected $fillable = [
        'comentario',
        'usuario_id',
        'pagoUsuario_id',
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el pago del usuario
    public function pagoUsuario()
    {
        return $this->belongsTo(PagoUsuario::class, 'pagoUsuario_id');
    }
}
