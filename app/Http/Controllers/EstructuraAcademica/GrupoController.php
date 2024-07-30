<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Carbon\Carbon;

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
        
        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

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

        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

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

    public function horariosMap($horarios)
    {
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $horarios_mapeados = [];

        foreach($dias as $dia){
            if(isset($horarios[$dia]) && $horarios[$dia]){
                $horarios_mapeados[$dia] = true;
                $horarios_mapeados[$dia.'_hora_inicio'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_inicio'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_inicio'];
                $horarios_mapeados[$dia.'_hora_fin'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_fin'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_fin'];
            }
        }
        
        return $horarios_mapeados;
    }
}
