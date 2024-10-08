<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;
    // Nombre de la tabla asociada a este modelo
    protected $table = 'visitantes';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'nombre',
        'identificacion',
        'empresa',
        'cargo',
    ];
}
