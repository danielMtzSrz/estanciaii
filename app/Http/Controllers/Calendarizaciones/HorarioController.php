<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\Horarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

class HorarioController extends Controller{

    public function index()
    {
        $horarios = Horarios::get()->map(function($horario){
            return [
                'id' => $horario->id,
                'aula' => $horario->aula,
                'aula_nombre' => $horario->aula->nombre,
                'dia_semana' => $horario->diasSemana(),
                'dia_semana_nombre' => $horario->diasSemana()['nombre'],
                'hora_inicio' => $horario->hora_inicio,
                'hora_fin' => $horario->hora_fin
            ];
        });
        $dias_semana = config('staticdata.dates.dias_semana');
        
        return Inertia::render('Calendarizaciones/Horarios/Index', compact('horarios', 'dias_semana'));
    }

    public function store(Request $request)
    {
        Horarios::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $horario = Horarios::find($id);

        $horario->update($request->all());
    
        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $horario = Horarios::find($id);

        $horario->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
