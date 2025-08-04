<?php

namespace App\Exports;

use App\Models\PagoUsuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class PagoYAbonosExport implements FromView
{
    protected $pagoId;

    public function __construct($pagoId)
    {
        $this->pagoId = $pagoId;
    }

    public function view(): View
    {
        $pago = PagoUsuario::with(['usuario', 'abonos'])->findOrFail($this->pagoId);

        return view('exports.pago_con_abonos', [
            'pago' => $pago,
            'abonos' => $pago->abonos,
        ]);
    }
}
