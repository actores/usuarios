<?php

namespace App\Exports;

use App\Models\TipoUsuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class TiposUsuariosExport implements FromCollection, WithHeadings
{
    protected $buscar;

    public function __construct($buscar = null)
    {
        $this->buscar = $buscar;
    }

    // Datos que se exportarán
    public function collection()
    {
        $query = TipoUsuario::query();

        if ($this->buscar) {
            $query->where('nombre', 'like', "%{$this->buscar}%");
        }

        // Ordenar por ID ascendente
        return $query->orderBy('id', 'asc')->get(['id', 'nombre']);
    }

    // Encabezados de columnas
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
        ];
    }
}
