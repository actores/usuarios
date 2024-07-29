<?php

namespace App\Exports;

use App\Models\SociosProduccion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class RepetorioIndividualExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize,WithEvents
{

    protected $socio_id;

    public function __construct($socio_id)
    {
        $this->socio_id = $socio_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('socios_producciones as sp')
            ->join('socios as s', 'sp.socio_id', '=', 's.id')
            ->join('producciones as p', 'sp.produccion_id', '=', 'p.id')
            ->select('sp.id', 's.nombre', 'p.tituloObra', 'sp.personaje')
            ->where('sp.socio_id', $this->socio_id)
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
