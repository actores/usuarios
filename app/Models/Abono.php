<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PagoUsuario;
use App\Models\TasaUsuario;

class Abono extends Model
{
    use HasFactory;

    protected $table = 'abonos';

    // Los campos que se pueden asignar en masa
    protected $fillable = [
        'pagoUsuario_id',
        'anio_pago',
        'importe',
        'tasa_administracion',
        'tasa_bienestar',
        'factura',
    ];

    // Relación con PagoUsuario
    public function pagoUsuario()
    {
        return $this->belongsTo(PagoUsuario::class, 'pagoUsuario_id');
    }

    // Relación con TasaUsuario
    public function tasa()
    {
        return $this->belongsTo(TasaUsuario::class, 'anio_pago');
    }
    
}
