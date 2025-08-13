<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasaUsuario extends Model
{
    use HasFactory;

    protected $table = 'tasas_usuarios';

    protected $fillable = [
        'anio',
        'tipo',
        'tasa',
    ];

    // Relación con Abono
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'anio_pago');
    }
}
