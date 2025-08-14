<?php

namespace App\Exports;

use App\Models\TasaUsuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasasExport implements FromCollection, WithHeadings
{
    protected $buscar;

    public function __construct($buscar = null)
    {
        $this->buscar = $buscar;
    }

    public function collection()
    {
        $query = TasaUsuario::query();

        if ($this->buscar) {
            $query->where('anio', 'like', "%{$this->buscar}%")
                  ->orWhere('tasa', 'like', "%{$this->buscar}%");
        }

        $tasas = $query->get()->groupBy('anio');

        $data = [];
        foreach ($tasas as $anio => $items) {
            $admin = $items->firstWhere('tipo', 1);
            $bienestar = $items->firstWhere('tipo', 2);

            $data[] = [
                'Año' => $anio,
                'Tasa Administración' => $admin ? $admin->tasa . ' %' : '-',
                'Tasa Bienestar' => $bienestar ? $bienestar->tasa . ' %' : '-',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return ['Año', 'Tasa Administración', 'Tasa Bienestar'];
    }
}
