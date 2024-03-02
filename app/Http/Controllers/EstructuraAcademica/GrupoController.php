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
                'tutor_nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                'nombre' => $grupo->nombre,
                'turno' => $grupo->turno(),
                'turno_nombre' => $grupo->turno()["nombre"]
            ];
        });

        return Inertia::render('EstructuraAcademica/Grupos/Index', compact('grupos'));
    }

    public function store(Request $request)
    {
        Grupo::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::find($id);

        $grupo->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        $grupo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
