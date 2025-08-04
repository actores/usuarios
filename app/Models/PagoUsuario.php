<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Abono;

class PagoUsuario extends Model
{
    use HasFactory;

    protected $table = 'pagos_usuarios';
    protected $fillable = [
        'usuario_id', 'anio_explotacion', 'importe', 'factura', 'estadoPago',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    protected $attributes = [
        'estadoPago' => 'Pendiente', // Valor predeterminado para estadoPago
    ];

    public function abonos()
    {
        return $this->hasMany(Abono::class, 'pagoUsuario_id');
    }
}
