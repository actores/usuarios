<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedor;
use App\Models\Abono;

class PagoProveedor extends Model
{
    use HasFactory;

    protected $table = 'pagos_proveedores';
    protected $fillable = [
        'proveedor_id', 'anio_explotacion', 'importe', 'factura', 'estadoPago',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    protected $attributes = [
        'estadoPago' => 'Pendiente', // Valor predeterminado para estadoPago
    ];

    public function abonos()
    {
        return $this->hasMany(Abono::class, 'pagoProveedor_id');
    }
}
