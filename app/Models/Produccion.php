<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;
    protected $table = 'producciones';

    protected $fillable = [
        'tituloObra',
        'personaje',
        'tipoProduccion',
        'país',
        'anio',
        'director',
        'socio_id',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }
}
