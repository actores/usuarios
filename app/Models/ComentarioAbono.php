<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioAbono extends Model
{
    use HasFactory;

    protected $table = 'comentarios_abonos';

    protected $fillable = [
        'comentario',
        'usuario_id',
        'abono_id',
    ];

    // Relación con el usuario que hizo el comentario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el abono
    public function abono()
    {
        return $this->belongsTo(Abono::class, 'abono_id');
    }
}
