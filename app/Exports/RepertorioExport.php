<?php

namespace App\Exports;

use App\Models\SociosProduccion;


use Maatwebsite\Excel\Concerns\FromCollection;

class RepertorioExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SociosProduccion::all();
    }
}
