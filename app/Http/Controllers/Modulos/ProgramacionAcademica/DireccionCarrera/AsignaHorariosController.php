<?php

namespace App\Http\Controllers\Modulos\ProgramacionAcademica\DireccionCarrera;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modulos\ProgramacionAcademica\DireccionCarrera\StoreAsignaHorariosRequest;
use App\Http\Requests\Modulos\ProgramacionAcademica\DireccionCarrera\UpdateAsignaHorariosRequest;
use App\Models\Calendarizaciones\DiaSemana;
use App\Models\Calendarizaciones\Horario;
use App\Models\Calendarizaciones\HorarioGrupoMateria;
use App\Models\Calendarizaciones\Periodo;
use App\Models\EstructuraAcademica\Aula;
use App\Models\GestionAcademica\GrupoMateria;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AsignaHorariosController extends Controller
{
    protected $periodo_activo;

    public function __construct()
    {
        $this->periodo_activo = Periodo::firstWhere('periodo_activo', 1);
    }

    public function index()
    {
        $gruposMateria = GrupoMateria::select('id', 'grupo_id', 'materia_id', 'periodo_id')
            ->with([
                'grupo' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'materia'  => function ($query) {
                    $query->select('id', 'nombre');
                },
                'horarioGrupoMateria' => function ($query) {
                    $query->select('id', 'horario_id', 'grupo_materia_id')->with([
                        'horario' => function ($subquery) {
                            $subquery->select('id', 'aula_id', 'dia_semana_id', 'hora_inicio', 'hora_fin')->with([
                                'aula' => function($deepQuery){
                                    $deepQuery->select('id', 'nombre');
                                },
                                'diaSemana' => function ($deepQuery) {
                                    $deepQuery->select('id', 'nombre');
                                }
                            ]);
                        }
                    ]);
                }
            ])
            ->where('periodo_id', $this->periodo_activo->id)
            ->get();
        return Inertia::render('Modulos/ProgramacionAcademica/DireccionCarrera/AsignaHorarios/Index', [
            'gruposMateria' => $gruposMateria,
            'periodo' => $this->periodo_activo
        ]);
    }

    public function store(StoreAsignaHorariosRequest $request)
    {
        try {
            $horario = Horario::firstOrCreate([
                'aula_id' => $request->input('aula_id'),
                'dia_semana_id' => $request->input('dia_semana_id'),
                'hora_inicio' => $request->input('hora_inicio'),
                'hora_fin' => $request->input('hora_fin'),
            ]);

            $horarioGM = HorarioGrupoMateria::firstOrCreate([
                'grupo_materia_id' => $request->input('grupo_materia_id'),
                'horario_id' => $horario->id
            ]);
            $horarioGM->created_at = Carbon::now();
            $horarioGM->updated_at = Carbon::now();
            $horarioGM->save();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Aula creada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $grupoMateria = GrupoMateria::with([
            'materia', 'grupo', 'periodo',
            'horarioGrupoMateria' => function ($query) {
                $query->select('id', 'horario_id', 'grupo_materia_id')->with([
                    'horario' => function ($subquery) {
                        $subquery->select('id', 'aula_id', 'dia_semana_id', 'hora_inicio', 'hora_fin')->with([
                            'aula' => function ($deepQuery) {
                                $deepQuery->select('id', 'nombre');
                            },
                            'diaSemana' => function ($deepQuery) {
                                $deepQuery->select('id', 'nombre');
                            }
                        ]);
                    }
                ]);
            }
        ])->find($id);
        
        $events = array();

        foreach($grupoMateria->horarioGrupoMateria as $evento){
            $evento = (object)[
                'title' => $evento->horario->aula->nombre,
                'startRecur' => $this->periodo_activo->fecha_inicio,
                'endRecur' => $this->periodo_activo->fecha_fin,
                'startTime' => $evento->horario->hora_inicio,
                'endTime' => $evento->horario->hora_fin,
                'daysOfWeek' => [strVal($evento->horario->dia_semana_id)],
                'classNames' => ['bg-secondary', 'border-0'],
            ];
            array_push($events, $evento);
        }
        return Inertia::render('Modulos/ProgramacionAcademica/DireccionCarrera/AsignaHorarios/Edit', [
            'grupoMateria' => $grupoMateria,
            'aulas' => Aula::select('id', 'nombre')->get(),
            'diasSemana' => DiaSemana::select('id', 'nombre')->get(),
            'events' => $events
        ]);
    }

    public function update(UpdateAsignaHorariosRequest $request, $id)
    {
        try {

            $horario = Horario::firstOrCreate([
                'aula_id' => $request->input('aula_id'),
                'dia_semana_id' => $request->input('dia_semana_id'),
                'hora_inicio' => $request->input('hora_inicio'),
                'hora_fin' => $request->input('hora_fin'),
            ]);
            $horarioGM = HorarioGrupoMateria::find($request->input('horario_grupo_materia_id'));

            $horarioGM_exists = HorarioGrupoMateria::where('horario_id', $horario->id)
                ->where('grupo_materia_id', $request->input('grupo_materia_id'))
                ->first();

            if($horarioGM_exists != null){
                //dd('already exists');
                $horarioGM_exists->updated_at = Carbon::now();
                $horarioGM_exists->save();
                $horarioGM->delete();
            } else {
                //dd('updating');
                $horarioGM->horario_id = $horario->id;
                $horarioGM->updated_at = Carbon::now();
                $horarioGM->save();
            }

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Aula modificada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        $horarioGM = HorarioGrupoMateria::find($id);
        
        try {

            $horarioGM->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Aula eliminada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }
}
