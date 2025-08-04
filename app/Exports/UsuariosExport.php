<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Usuario::with('tipo') // Suponiendo que tengas la relación
            ->get()
            ->map(function ($usuario) {
                return [
                    'ID'        => $usuario->id,
                    'Nombre'    => $usuario->nombre,
                    'Tipo'      => $usuario->tipo->nombre ?? '', // Asegúrate de tener la relación tipo()
                    'NIT'       => $usuario->nit,
                    'Dirección' => $usuario->direccion,
                    'Ciudad'    => $usuario->ciudad,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Tipo', 'NIT', 'Dirección', 'Ciudad'];
    }
}
