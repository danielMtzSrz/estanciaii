<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\GrupoMateria;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Carbon\Carbon;

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
        })
        ->sortBy('grupo_nombre')
        ->values();

        return Inertia::render('GestionAcademica/GrupoMateria/Index', compact('grupo_materias'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated_data = $request->validate([
            'profesor_id' => 'required',
            'materia_id' => 'required',
            'grupo_id' => 'required',
            'periodo_id' => 'required',
            'horarios' => 'array|horarios_no_duplicados:'.$input['grupo_id'].','.null,
        ]);
     
        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);
        
        GrupoMateria::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $grupo_materia = GrupoMateria::find($id);

        $validated_data = $request->validate([
            'profesor_id' => 'required',
            'materia_id' => 'required',
            'grupo_id' => 'required',
            'periodo_id' => 'required',
            'horarios' => 'array|horarios_no_duplicados:'.$input['grupo_id'].','.$grupo_materia['materia_id']
        ]);

        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

        $grupo_materia->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $grupo_materia = GrupoMateria::find($id);

        $grupo_materia->delete();

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
