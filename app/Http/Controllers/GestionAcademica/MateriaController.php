<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\Materia;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with(['planEstudios'])->get()->map(function($materia){
            return [
                'id' => $materia->id,
                'plan_estudios' => [
                    'id' => $materia->planEstudios->id ?? null,
                    'mapa_curricular_clave_mapa_curricular' => $materia->planEstudios->mapaCurricular->clave_mapa_curricular ?? null
                ],
                'plan_estudios_clave' => $materia->planEstudios->mapaCurricular->clave_mapa_curricular ?? null,
                'cuatrimestre' => $materia->cuatrimestre(),
                'cuatrimestre_nombre' => $materia->cuatrimestre()['nombre'],
                'nombre' => $materia->nombre,
                'color' => $materia->color,
            ];
        });

        return Inertia::render('GestionAcademica/Materias/Index', compact('materias'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            "cuatrimestre_id" => 'required',
            "plan_estudios_id" => 'required',
            "nombre" => 'required',
            "color" => 'required'
        ]);

        Materia::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            "cuatrimestre_id" => 'required',
            "plan_estudios_id" => 'required',
            "nombre" => 'required',
            "color" => 'required'
        ]);

        $materia = Materia::find($id);
            
        $materia->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);
            
        $materia->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
