<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PagoProveedor;
use App\Models\TasaProveedor;


class Abono extends Model
{
    use HasFactory;
    protected $table = 'abonos';
    protected $fillable = [
        'pagoProveedor_id',
        'anio_pago',
        'importe',
        'tasa_administracion',
        'tasa_bienestar',
        'factura',
    ];

    public function pagoProveedor()
    {
        return $this->belongsTo(PagoProveedor::class, 'pagoProveedor_id');
    }

}
