<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\EstructuraAcademica\Aula;
use App\Models\Calendarizaciones\{Horarios, DiaSemana};
use App\Http\Requests\Calendarizaciones\{StoreHorarioRequest, UpdateHorarioRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

class HorarioController extends Controller{

    public function index(){
        $horarios = Horarios::all()->transform(function($horario){
            return [
                'id' => $horario->id,
                'aula' => $horario->aula,
                'diaSemana' => $horario->diaSemana,
                'hora_inicio' => $horario->hora_inicio,
                'hora_fin' => $horario->hora_fin,
            ];
        });        
        $diasSemana = DiaSemana::all();
        $aulas = Aula::all();
        return Inertia::render('Calendarizaciones/Horarios/Index', compact('horarios', 'diasSemana', 'aulas'));
    }

    public function create(){
        //
    }

    public function store(StoreHorarioRequest $request){
        try {
 
            Horarios::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Horario creado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function show(Horarios $horarios){
        //
    }

    public function edit(Horarios $horarios){
        //
    }

    public function update(UpdateHorarioRequest $request, $id){
        
        $horario = Horarios::find($id);

        try {
 
            $horario->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Horario modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $horario = Horarios::find($id);
        
        try {
 
            $horario->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Horario eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $horarios = Horarios::onlyTrashed()->get()->transform(function($horario){
            return [
                'id' => $horario->id,
                'aula' => $horario->aula,
                'diaSemana' => $horario->diaSemana,
                'hora_inicio' => $horario->hora_inicio,
                'hora_fin' => $horario->hora_fin,
                'deleted_at' => $horario->deleted_at
            ];
        });

        return Inertia::render("Calendarizaciones/Horarios/Trashed", compact('horarios'));
    }

    public function restore($id){
        
        $horario = Horarios::withTrashed()->findOrFail($id);
        $horario->restore();

        return Redirect::route('Calendarizaciones.Horarios.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Horario restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $horario = Horarios::withTrashed()->findOrFail($id);
        $horario->forceDelete();

        return Redirect::route('Calendarizaciones.Horarios.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Horario eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
