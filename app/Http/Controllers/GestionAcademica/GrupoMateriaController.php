<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\GrupoMateria;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GrupoMateriaController extends Controller
{
    public function index()
    {
        $grupo_materias = GrupoMateria::with(['profesor', 'materia', 'grupo', 'periodo'])->get()->map(function($grupo_materia){
            return [
                'id' => $grupo_materia->id,
                'profesor' => [
                    'id' => $grupo_materia->profesor->id,
                    'nombre' => $grupo_materia->profesor->name." ".$grupo_materia->profesor->apellido_paterno." ".$grupo_materia->profesor->apellido_materno,
                    'profile_photo_path' => $grupo_materia->profesor->profile_photo_path
                ],
                'profesor_nombre' => $grupo_materia->profesor->name." ".$grupo_materia->profesor->apellido_paterno." ".$grupo_materia->profesor->apellido_materno,
                'materia' => $grupo_materia->materia,
                'materia_nombre' => $grupo_materia->materia->nombre,
                'grupo' => $grupo_materia->grupo,
                'grupo_nombre' => $grupo_materia->grupo->nombre,
                'periodo' => $grupo_materia->periodo,
                'periodo_nombre' => $grupo_materia->periodo->titulo,
                'horarios' => $grupo_materia->horarios,
            ];
        });

        return Inertia::render('GestionAcademica/GrupoMateria/Index', compact('grupo_materias'));
    }

    public function store(Request $request)
    {
        $grupo_materia = GrupoMateria::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $grupo_materia = GrupoMateria::find($id);

        $grupo_materia->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $grupo_materia = GrupoMateria::find($id);

        $grupo_materia->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
