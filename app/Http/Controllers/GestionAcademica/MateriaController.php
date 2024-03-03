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
                    'id' => $materia->planEstudios->id,
                    'mapa_curricular_clave_mapa_curricular' => $materia->planEstudios->mapaCurricular->clave_mapa_curricular
                ],
                'plan_estudios_clave' => $materia->planEstudios->mapaCurricular->clave_mapa_curricular,
                'cuatrimestre' => $materia->cuatrimestre(),
                'cuatrimestre_nombre' => $materia->cuatrimestre()['nombre'],
                'nombre' => $materia->nombre
            ];
        });

        return Inertia::render('GestionAcademica/Materias/Index', compact('materias'));
    }

    public function store(Request $request)
    {
        Materia::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $materia = Materia::find($id);
            
        $materia->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);
            
        $materia->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
