<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SociosProduccion extends Model
{
    use HasFactory;

    // Tabla asociada con el modelo
    protected $table = 'socios_producciones';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = ['socio_id', 'produccion_id', 'personaje'];

    // Relación con el modelo Socio
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    // Relación con el modelo Produccion
    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
