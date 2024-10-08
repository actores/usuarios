<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';

    protected $fillable = [
        'socio_id',
        'visitante_id',
        'fecha',
        'hora_entrada',
        'hora_salida', 
        'area',
        'motivo',
        'tipo'           
    ];

    // Relación con el modelo Socio
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }

    // Relación con el modelo Visitante
    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'visitante_id');
    }
}
