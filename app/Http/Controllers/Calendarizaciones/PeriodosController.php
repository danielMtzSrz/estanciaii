<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\Calendarizaciones\{Periodo, TipoPeriodo};
use App\Http\Requests\Calendarizaciones\StorePeriodoRequest;
use App\Http\Requests\Calendarizaciones\UpdatePeriodoRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PeriodosController extends Controller{

    public function index(){
        $periodos = Periodo::all()->transform(function($periodo){
            return [
                'id' => $periodo->id,
                'tipoPeriodo' => $periodo->tipoPeriodo,
                'titulo' => $periodo->titulo,
                'descripcion' => $periodo->descripcion,
                'fecha_inicio' => $periodo->fecha_inicio,
                'fecha_fin' => $periodo->fecha_fin,
                'periodo_activo' => $periodo->periodo_activo
            ];
        });
        $tipoperiodos = TipoPeriodo::orderBy('nombre', 'ASC')->get();
        
        return Inertia::render('Calendarizaciones/Periodos/Index', compact('periodos', 'tipoperiodos'));
    }

    public function create(){
        //
    }

    public function store(StorePeriodoRequest $request){
        
        try {
 
            Periodo::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Periodo creado correctamente',
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

    public function update(UpdatePeriodoRequest $request, $id){
        
        $periodo = Periodo::find($id);

        try {
 
            $periodo->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Periodo modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $periodo = Periodo::find($id);
        
        try {
 
            $periodo->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Periodo eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $periodos = Periodo::onlyTrashed()->get()->transform(function($periodo){
            return [
                'id' => $periodo->id,
                'tipoPeriodo' => $periodo->tipoPeriodo,
                'titulo' => $periodo->titulo,
                'descripcion' => $periodo->descripcion,
                'fecha_inicio' => $periodo->fecha_inicio,
                'fecha_fin' => $periodo->fecha_fin,
                'periodo_activo' => $periodo->periodo_activo
            ];
        });

        return Inertia::render("Calendarizaciones/Periodos/Trashed", compact('periodos'));
    }

    public function restore($id){
        
        $periodo = Periodo::withTrashed()->findOrFail($id);
        $periodo->restore();

        return Redirect::route('Calendarizaciones.Periodos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Periodo restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $periodo = Periodo::withTrashed()->findOrFail($id);
        $periodo->forceDelete();

        return Redirect::route('Calendarizaciones.Periodos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Periodo eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
