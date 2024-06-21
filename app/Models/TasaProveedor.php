<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasaProveedor extends Model
{
    use HasFactory;

    protected $table = 'tasas_proveedor';

    protected $fillable = [
        'anio',
        'tipo',
        'tasa',
    ];
}
