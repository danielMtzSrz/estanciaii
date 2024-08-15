<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\PlanEstudio;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanEstudioController extends Controller
{
    public function index()
    {
        $planes_estudio = PlanEstudio::with(['carrera', 'mapaCurricular'])->get()->map(function($plan_estudio){
            return [
                'id' => $plan_estudio->id,
                'mapa_curricular' => $plan_estudio->mapaCurricular,
                'mapa_curricular_clave_mapa_curricular' => $plan_estudio->mapaCurricular->clave_mapa_curricular,
                'carrera' => $plan_estudio->carrera,
                'carrera_imagen' => $plan_estudio->carrera->imagen,
                'carrera_nombre' => $plan_estudio->carrera->nombre,
                'estatus' => $plan_estudio->estatus ? 'Activo' : 'Inactivo'
            ];
        });

        return Inertia::render('GestionAcademica/PlanesEstudios/Index', compact('planes_estudio'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'carrera_id' => 'required',
            'mapa_curricular_id' => 'required',
            'estatus' => 'required'
        ]);

        PlanEstudio::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'carrera_id' => 'required',
            'mapa_curricular_id' => 'required',
            'estatus' => 'required'
        ]);

        $planEstudio = PlanEstudio::find($id);
            
        $planEstudio->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $planEstudio = PlanEstudio::find($id);

        $planEstudio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
