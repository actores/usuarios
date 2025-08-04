<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'idTipo',
        'nit',
        'direccion',
        'ciudad',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_id');
    }
}
