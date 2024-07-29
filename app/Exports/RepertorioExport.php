<?php

namespace App\Exports;

use App\Models\SociosProduccion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RepertorioExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('socios_producciones as sp')
        ->join('socios as s', 'sp.socio_id', '=', 's.id')
        ->join('producciones as p', 'sp.produccion_id', '=', 'p.id')
        ->select('sp.id', 's.nombre', 'p.tituloObra', 'sp.personaje')
        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre del Socio',
            'Título de la Obra',
            'Personaje'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Aplicar negrilla a la primera fila (encabezados)
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID
            'B' => 30,  // Nombre del Socio
            'C' => 50,  // Título de la Obra
            'D' => 30,  // Personaje
        ];
    }
}
