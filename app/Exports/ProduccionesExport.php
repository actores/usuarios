<?php

namespace App\Exports;

use App\Models\Produccion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ProduccionesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Produccion::select('tituloObra', 'tipoProduccion','pais','anio','director')->get();
    }

    public function headings(): array
    {
        return [
            'Título Obra',
            'Tipo Producción',
            'País',
            'Año',
            'Director'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Aplicar negrilla a la primera fila (encabezados)
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A', $event->sheet->getHighestColumn()) as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
