<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\GrupoMateria;
use App\Models\EstructuraAcademica\Grupo;

use App\Exports\HorariosMateriaExport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Carbon\Carbon;

class GrupoMateriaController extends Controller
{
    public function index()
    {
        $grupo_materias = GrupoMateria::with(['profesor', 'materia', 'grupo'])->get()->map(function($grupo_materia){
            return [
                'id' => $grupo_materia->id,
                'profesor' => [
                    'id' => $grupo_materia->profesor->id,
                    'nombre' => $grupo_materia->profesor->name." ".$grupo_materia->profesor->apellido_paterno." ".$grupo_materia->profesor->apellido_materno,
                    'profile_photo_path' => $grupo_materia->profesor->profile_photo_path,
                    'horarios' => $grupo_materia->profesor->horarios
                ],
                'profesor_nombre' => $grupo_materia->profesor->name." ".$grupo_materia->profesor->apellido_paterno." ".$grupo_materia->profesor->apellido_materno,
                'materia' => $grupo_materia->materia,
                'materia_nombre' => $grupo_materia->materia->nombre,
                'grupo' => $grupo_materia->grupo,
                'grupo_nombre' => $grupo_materia->grupo->nombre,
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

        $grupo = Grupo::find($input['grupo_id']);

        $validated_data = $request->validate([
            'profesor_id' => 'required',
            'materia_id' => 'required',
            'grupo_id' => 'required',
            'horarios' => 'array|horarios_no_duplicados:'.$input['grupo_id'].','.null.','.$grupo->periodo_id,
        ]);
     
        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);
        
        GrupoMateria::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $grupo = Grupo::find($input['grupo_id']);
        $grupo_materia = GrupoMateria::find($id);

        $validated_data = $request->validate([
            'profesor_id' => 'required',
            'materia_id' => 'required',
            'grupo_id' => 'required',
            'horarios' => 'array|horarios_no_duplicados:'.$input['grupo_id'].','.$grupo_materia['materia_id'].','.$grupo->periodo_id
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

    public function generarHorarioMateria($id)
    {
        $grupo = Grupo::with(['aula', 'carrera', 'tutor', 'periodo', 'grupoMateria' => function($query) {
            $query->with(['profesor', 'materia', 'grupo']);
        }])
        ->where('id', $id)
        ->first();

        $edificio_nombre = ($grupo->first() && $grupo->first()->aula) ? $grupo->first()->aula->edificio()['nombre'] : null;
        $aula_nombre = ($grupo->first() && $grupo->first()->aula) ? $grupo->first()->aula->nombre : null;

        $encabezado = [
            'carrera' => optional($grupo->first())->carrera->nombre ?? null,
            'periodo' => optional($grupo->first())->periodo->titulo ?? null,
            'aula' => $edificio_nombre.' '.$aula_nombre,
            'grupo' => optional($grupo->first())->nombre ?? null,
            'turno' => optional($grupo->first()?->turno())["nombre"] ?? null
        ];

        $horarios_grupo = $grupo->grupoMateria->map(function($grupo_materia) {
            $materia_nombre = isset($grupo_materia->materia->nombre) ? $grupo_materia->materia->nombre : 'Sin materia';
            $materia_color = isset($grupo_materia->materia->color) ? $grupo_materia->materia->color : '#FFFFFF';
            $materia_horario = isset($grupo_materia->horarios) ? $grupo_materia->horarios : null;
            return [
                'horario_materia' => $this->transformarHorariosConCarbon($materia_nombre, $materia_color, $materia_horario)
            ];
        });

        return Excel::download(new HorariosMateriaExport($horarios_grupo->toArray(), $encabezado), 'horario_'.$encabezado['grupo'].'_'.$encabezado['periodo'].'.xlsx');
    }

    public function transformarHorariosConCarbon($materia_nombre, $materia_color, $materia_horario)
    {
        $diasMapa = ['lunes' => 1, 'martes' => 2, 'miercoles' => 3, 'jueves' => 4, 'viernes' => 5, 'sabado' => 6, 'domingo' => 0];
    
        $horarios = [];
    
        foreach ($diasMapa as $dia => $numeroDia) {
            if (isset($materia_horario[$dia]) && $materia_horario[$dia] === true) {
                $startTimeKey = $dia . '_hora_inicio';
                $endTimeKey = $dia . '_hora_fin';
    
                $startTime = isset($materia_horario[$startTimeKey]) ? Carbon::parse($materia_horario[$startTimeKey])->setTimezone('America/Mexico_City')->format('H:i:s') : null;
                $endTime = isset($materia_horario[$endTimeKey]) ? Carbon::parse($materia_horario[$endTimeKey])->setTimezone('America/Mexico_City')->format('H:i:s') : null;
    
                if ($startTime && $endTime) {
                    $horarios[] = [
                        'day' => $numeroDia,
                        'startTime' => $startTime,
                        'endTime' => $endTime,
                    ];
                }
            }
        }
    
        $horariosAgrupados = [];
    
        foreach ($horarios as $horario) {
            $key = $horario['startTime'] . '_' . $horario['endTime'];
            if (!isset($horariosAgrupados[$key])) {
                $horariosAgrupados[$key] = [
                    'title' => $materia_nombre,
                    'color' => $materia_color,
                    'startTime' => $horario['startTime'],
                    'endTime' => $horario['endTime'],
                    'daysOfWeek' => [],
                ];
            }
            $horariosAgrupados[$key]['daysOfWeek'][] = $horario['day'];
        }
    
        return array_values($horariosAgrupados);
    }
}
