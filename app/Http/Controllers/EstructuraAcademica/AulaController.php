<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Http\Requests\EstructuraAcademica\StoreAulaRequest;
use App\Http\Requests\EstructuraAcademica\UpdateAulaRequest;

use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\Edificio;
use App\Models\EstructuraAcademica\TipoAula;

use App\Exports\HorariosAula;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

use Carbon\Carbon;

class AulaController extends Controller
{

    public function index()
    {
        $aulas = Aula::get()->map(function($aula){
            return $aula->indexMap();
        });
        $edificios = config('staticdata.estructura_academica.edificios');
        $tipos_aula = config('staticdata.estructura_academica.tipos_aulas');

        return Inertia::render('EstructuraAcademica/Aulas/Index', compact('aulas', 'edificios', 'tipos_aula'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'edificio_id' => 'required',
            'tipo_aula_id' => 'required',
            'nombre' => 'required',
            'capacidad' => 'required',
            'horarios' => 'required'
        ]);

        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

        Aula::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'edificio_id' => 'required',
            'tipo_aula_id' => 'required',
            'nombre' => 'required',
            'capacidad' => 'required',
            'horarios' => 'required'
        ]);

        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

        $aula = Aula::find($id);

        $aula->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $aula = Aula::find($id);
        
        $aula->delete();

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

    public function generarHorarios($aula_id, $periodo_id)
    {
        $aula = Aula::with('grupo')->where('id', $aula_id)->first();
        
        $grupos = $aula->grupo->filter(function($grupo) use ($periodo_id){
            return $grupo->periodo_id == $periodo_id;
        })->load(['aula', 'carrera', 'tutor', 'grupoMateria' => function($query) {
                $query->with(['profesor', 'materia', 'grupo']);
            }
        ]);

        $grupo_turno_vespertino = collect();
        $grupo_turno_matutino = collect();

        $grupos->each(function ($grupo) use ($grupo_turno_vespertino, $grupo_turno_matutino) {
            if ($grupo->turno == 1) {
                $grupo_turno_matutino->push($grupo);
            } elseif ($grupo->turno == 2) {
                $grupo_turno_vespertino->push($grupo);
            }
        });

        $horariosMatutino = ($grupo_turno_matutino->first() && $grupo_turno_matutino->first()->grupoMateria) ? $grupo_turno_matutino->first()->grupoMateria->map(function($grupo_materia) {
            $materia_nombre = isset($grupo_materia->materia->nombre) ? $grupo_materia->materia->nombre : 'Sin materia';
            $materia_color = isset($grupo_materia->materia->color) ? $grupo_materia->materia->color : '#FFFFFF';
            $materia_horario = isset($grupo_materia->horarios) ? $grupo_materia->horarios : null;
        
            return [
                'horario_materia' => $this->transformarHorariosConCarbon($materia_nombre, $materia_color, $materia_horario)
            ];
        })->toArray() : [];

        $horariosVespertino = ($grupo_turno_vespertino->first() && $grupo_turno_vespertino->first()->grupoMateria) 
            ? $grupo_turno_vespertino
                ->first()->grupoMateria
                ->map(function($grupo_materia) {
                    $materia_nombre = isset($grupo_materia->materia->nombre) ? $grupo_materia->materia->nombre : 'Sin materia';
                    $materia_color = isset($grupo_materia->materia->color) ? $grupo_materia->materia->color : '#FFFFFF';
                    $materia_horario = isset($grupo_materia->horarios) ? $grupo_materia->horarios : null;
                    return [
                        'horario_materia' => $this->transformarHorariosConCarbon($materia_nombre, $materia_color, $materia_horario)
                    ];
                })->toArray() 
            : [];

        $edificio_nombre = ($grupo_turno_matutino->first() && $grupo_turno_matutino->first()->aula) ? $grupo_turno_matutino->first()->aula->edificio()['nombre'] : null;
        $aula_nombre = ($grupo_turno_matutino->first() && $grupo_turno_matutino->first()->aula) ? $grupo_turno_matutino->first()->aula->nombre : null;

        $encabezado_matutino = [
            'carrera' => optional($grupo_turno_matutino->first())->carrera->nombre ?? null,
            'periodo' => optional($grupo_turno_matutino->first())->periodo->titulo ?? null,
            'aula' => $edificio_nombre.' '.$aula_nombre,
            'grupo' => optional($grupo_turno_matutino->first())->nombre ?? null,
            'turno' => optional($grupo_turno_matutino->first()?->turno())["nombre"] ?? null
        ];

        $edificio_nombre = ($grupo_turno_vespertino->first() && $grupo_turno_vespertino->first()->aula) ? $grupo_turno_vespertino->first()->aula->edificio()['nombre'] : null;
        $aula_nombre = ($grupo_turno_vespertino->first() && $grupo_turno_vespertino->first()->aula) ? $grupo_turno_vespertino->first()->aula->nombre : null;

        $encabezado_vespertino = [
            'carrera' => optional($grupo_turno_vespertino->first())->carrera->nombre ?? null,
            'periodo' => optional($grupo_turno_vespertino->first())->periodo->titulo ?? null,
            'aula' => $edificio_nombre.' '.$aula_nombre,
            'grupo' => optional($grupo_turno_vespertino->first())->nombre ?? null,
            'turno' => optional($grupo_turno_vespertino->first()?->turno())["nombre"] ?? null
        ];

        return Excel::download(new HorariosAula($horariosMatutino, $horariosVespertino, $encabezado_matutino, $encabezado_vespertino), 'horarios.xlsx');
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
