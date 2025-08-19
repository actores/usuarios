<?php

namespace App\Http\Controllers\Distribucion;

use App\Http\Controllers\Controller;
use App\Models\PagoUsuario;
use Illuminate\Http\Request;

class ResumenPagosController extends Controller
{
    // Listar pagos con totales de tasas
    public function listar()
    {
        $pagos = PagoUsuario::with('abonos') // Asegúrate de definir la relación
            ->get()
            ->map(function ($pago) {
                $totalAdmin = $pago->abonos->sum('tasa_administracion');
                $totalBienestar = $pago->abonos->sum('tasa_bienestar');

                return [
                    'id' => $pago->id,
                    'anio_explotacion' => $pago->anio_explotacion,
                    'importe' => $pago->importe,
                    'total_admin' => $totalAdmin,
                    'total_bienestar' => $totalBienestar,
                ];
            });

        return view('procesos.distribucion.index', compact('pagos'));
    }
}
