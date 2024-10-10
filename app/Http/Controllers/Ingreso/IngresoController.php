<?php

namespace App\Http\Controllers\Ingreso;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Ingreso;
use App\Models\Socio;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Carbon\Carbon;


class IngresoController extends Controller
{
    public function index()
    {

        // Crear una consulta SQL en crudo para unir ambas tablas
        $personas = DB::select("
        SELECT id, identificacion, nombre, '0' as tipo_persona FROM socios
        UNION ALL
        SELECT id, identificacion, nombre, '1' as tipo_persona FROM visitantes
    ");


        return view('procesos.ingreso.ingreso')->with('personas', $personas);
    }



    public function IngresoRegistro(Request $request)
    {
        if ($request->tipoPersona == 0) {
            $data = [
                'socio_id' => $request->idSocioVisitante,
                'fecha' => $request->inputFechaIngreso,
                'hora_entrada' => $request->inputHoraIngreso,
                'area' => $request->inputAreaVisita,
                'motivo' => $request->inputMotivoVisita,
                'tipo' => $request->tipoPersona
            ];

            $ingreso = Ingreso::create($data);
            session()->flash('success', 'Socio ingresado correctamente');
        } else if ($request->tipoPersona == 1) {
            $data = [
                'visitante_id' => $request->idSocioVisitante,
                'fecha' => $request->inputFechaIngreso,
                'hora_entrada' => $request->inputHoraIngreso,
                'area' => $request->inputAreaVisita,
                'motivo' => $request->inputMotivoVisita,
                'tipo' => $request->tipoPersona
            ];
            $ingreso = Ingreso::create($data);
            session()->flash('success', 'Visitante ingresado correctamente');
        } else {
            session()->flash('warning', 'Lo sentimos, ha ocurrido un error. Intentelo nuevamente');
        }
        return redirect()->route('ingreso');
    }

    public function listarIngresos()
    {
        $ingresos = DB::table('ingresos as i')
            ->leftJoin('socios as s', 'i.socio_id', '=', 's.id')
            ->leftJoin('visitantes as v', 'i.visitante_id', '=', 'v.id')
            ->select(
                'i.id',
                'i.socio_id',
                'i.visitante_id',
                's.identificacion as socio_identificacion',
                's.nombre as socio_nombre',
                'v.identificacion as visitante_identificacion',
                'v.nombre as visitante_nombre',
                'i.fecha',
                'i.hora_entrada',
                'i.hora_salida',
                'i.area',
                'i.motivo',
                'i.tipo'
            )
            ->get();

        $ingresos->transform(function ($ingreso) {
            // Formato de la fecha: dd/mm/yyyy
            $ingreso->fecha = Carbon::parse($ingreso->fecha)->format('d/m/Y');

            // Formato de la hora_entrada: hh:mm AM/PM
            $ingreso->hora_entrada = Carbon::parse($ingreso->hora_entrada)->format('h:i A');

            // Verificación de null para hora_salida
            if (!is_null($ingreso->hora_salida)) {
                $ingreso->hora_salida = Carbon::parse($ingreso->hora_salida)->format('h:i A');
            } else {
                $ingreso->hora_salida = null; // Mantiene null o asigna un valor como 'No registrado' si prefieres
            }

            return $ingreso;
        });

        return view('procesos.ingreso.index')->with('ingresos', $ingresos);
    }

    public function darSalida($id)
    {
        $ingreso = Ingreso::find($id);

        if ($ingreso) {
            // Actualizar el campo hora_salida con la hora actual
            $ingreso->hora_salida = Carbon::now()->format('H:i:s');
            $ingreso->save(); // Guardar los cambios en la base de datos

            session()->flash('success', 'Salida registrada correctamente');
            return redirect()->route('listarIngresos');
        }
    }
}
