<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\AulaReservacion;
use App\Models\User;

use Illuminate\Http\Request;

use Inertia\Inertia;

class AulaReservacionController extends Controller{

    public function index()
    {
        $aulas_reservacion = AulaReservacion::with(['aula', 'solicitante'])->get()->map(function($aula_reservacion){
            return [
                'id' => $aula_reservacion->id,
                'aula' => $aula_reservacion->aula,
                'aula_nombre' => $aula_reservacion->aula->nombre,
                'solicitante' => [
                    'id' => $aula_reservacion->solicitante->id,
                    'nombre' => $aula_reservacion->solicitante->name." ".$aula_reservacion->solicitante->apellido_paterno." ".$aula_reservacion->solicitante->apellido_materno,
                    'profile_photo_path' => $aula_reservacion->solicitante->profile_photo_path
                ],
                'solicitante_profile_photo_path' => $aula_reservacion->solicitante->profile_photo_path,
                'solicitante_nombre' => $aula_reservacion->solicitante->name." ".$aula_reservacion->solicitante->apellido_paterno." ".$aula_reservacion->solicitante->apellido_materno,
                'horario_inicio' => $aula_reservacion->horario_inicio,
                'horario_final' => $aula_reservacion->horario_final,
                'asunto' => $aula_reservacion->asunto,
                'descripcion' => $aula_reservacion->descripcion
            ];
        });

        return Inertia::render('EstructuraAcademica/AulasReservacion/Index', compact('aulas_reservacion'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'aula_id' => 'required',
            'solicitante_id' => 'required',
            'horario_inicio' => 'required',
            'horario_final' => 'required',
            'asunto' => 'required',
            'descripcion' => 'required'
        ]);

        AulaReservacion::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'aula_id' => 'required',
            'solicitante_id' => 'required',
            'horario_inicio' => 'required',
            'horario_final' => 'required',
            'asunto' => 'required',
            'descripcion' => 'required'
        ]);

        $aula_reservacion = AulaReservacion::find($id);

        $aula_reservacion->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $aula_reservacion = AulaReservacion::find($id);

        $aula_reservacion->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}