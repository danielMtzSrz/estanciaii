<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GrupoController extends Controller{

    public function index()
    {
        $grupos = Grupo::with(['aula', 'carrera', 'tutor'])->get()->map(function($grupo){
            return [
                'id' => $grupo->id,
                'carrera' => $grupo->carrera,
                'carrera_nombre' => $grupo->carrera->nombre,
                'aula' => $grupo->aula,
                'aula_nombre' => $grupo->aula->nombre,
                'tutor' => [
                    'id' => $grupo->tutor->id,
                    'nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                    'profile_photo_path' => $grupo->tutor->profile_photo_path
                ],
                'horarios' => $grupo->horarios,
                'tutor_nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                'nombre' => $grupo->nombre,
                'turno' => $grupo->turno(),
                'turno_nombre' => $grupo->turno()["nombre"],
                'periodo' => $grupo->periodo,
                'periodo_nombre' => $grupo->periodo->titulo,
            ];
        });

        return Inertia::render('EstructuraAcademica/Grupos/Index', compact('grupos'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'carrera_id' => 'required',
            'aula_id' => 'required',
            'tutor_id' => 'required',
            'periodo_id' => 'required',
            'nombre' => 'required',
            'turno' => 'required',
            'horarios' => 'required'
        ]);
        
        Grupo::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'carrera_id' => 'required',
            'aula_id' => 'required',
            'tutor_id' => 'required',
            'periodo_id' => 'required',
            'nombre' => 'required',
            'turno' => 'required',
            'horarios' => 'required'
        ]);

        $grupo = Grupo::find($id);

        $grupo->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        $grupo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
