<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribucion extends Model
{
    use HasFactory;

    protected $table = 'distribuciones';

    protected $fillable = [
        'anioDistribucion',
        'pagoProveedor_id',
        'estado',
    ];

    protected $attributes = [
        'estado' => 'Sin Distribuir', // Valor predeterminado para estadoPago
    ];
}
