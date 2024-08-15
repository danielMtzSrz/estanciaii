<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\MapaCurricular;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class MapaCurricularController extends Controller
{
    public function index()
    {
        $mapas_curriculares = MapaCurricular::get()->map(function($mapa_curricular){
            return [
                'id' => $mapa_curricular->id,
                'clave_mapa_curricular' => $mapa_curricular->clave_mapa_curricular,
                'total_cuatrimestres' => $mapa_curricular->total_cuatrimestres,
                'total_horas' => $mapa_curricular->total_horas,
                'total_creditos' => $mapa_curricular->total_creditos,
                'total_materias' => $mapa_curricular->total_materias,
                'duracion' => $mapa_curricular->duracion,
                'vigencia' => $mapa_curricular->vigencia,
                'fecha_revision' => $mapa_curricular->fecha_revision,
                'fecha_revision_format' => Carbon::parse($mapa_curricular->fecha_revision)->format('Y-m-d')
            ];
        });

        return Inertia::render('GestionAcademica/MapasCurriculares/Index', compact('mapas_curriculares'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'clave_mapa_curricular' => 'required',
            'total_cuatrimestres' => 'required',
            'total_horas' => 'required',
            'total_creditos' => 'required',
            'total_materias' => 'required',
            'duracion' => 'required',
            'vigencia' => 'required',
            'fecha_revision' => 'required'
        ]);

        MapaCurricular::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'clave_mapa_curricular' => 'required',
            'total_cuatrimestres' => 'required',
            'total_horas' => 'required',
            'total_creditos' => 'required',
            'total_materias' => 'required',
            'duracion' => 'required',
            'vigencia' => 'required',
            'fecha_revision' => 'required'
        ]);

        $mapaCurricular = MapaCurricular::find($id);

        $mapaCurricular->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $mapaCurricular = MapaCurricular::find($id);

        $mapaCurricular->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
