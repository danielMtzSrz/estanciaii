<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\Calendarizaciones\TiposPeriodos;
use App\Http\Requests\Calendarizaciones\StoreDiaSemanaRequest;
use App\Http\Requests\Calendarizaciones\UpdateDiaSemanaRequest;
use App\Models\Calendarizaciones\DiaSemana;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class DiaSemanaController extends Controller{

    public function index(){
        $diasSemana = DiaSemana::all();
        return Inertia::render('Calendarizaciones/DiasSemana/Index', compact('diasSemana'));
    }

    public function create(){
        //
    }

    public function store(StoreDiaSemanaRequest $request){
        
        try {
 
            DiaSemana::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'color' => $request->color
            ]);

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Día de la semana creado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function show(TipoPeriodo $tipoPeriodo){
        //
    }

    public function edit(TipoPeriodo $tipoPeriodo){
        //
    }

    public function update(UpdateDiaSemanaRequest $request, $id){
        
        $tipoPeriodo = DiaSemana::find($id);

        try {
 
            $tipoPeriodo->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Día de la semana modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $tipoPeriodo = DiaSemana::find($id);
        
        try {
 
            $tipoPeriodo->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Día de la semana eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $diasSemana = DiaSemana::onlyTrashed()->get();

        return Inertia::render("Calendarizaciones/DiasSemana/Trashed", compact('diasSemana'));
    }

    public function restore($id){
        
        $diaSemana = DiaSemana::withTrashed()->findOrFail($id);
        $diaSemana->restore();

        return Redirect::route('Calendarizaciones.DiasSemana.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Día de la semana restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $diaSemana = DiaSemana::withTrashed()->findOrFail($id);
        $diaSemana->forceDelete();

        return Redirect::route('Calendarizaciones.DiasSemana.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Día de la semana eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
