<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\Calendarizaciones\TiposPeriodos;
use App\Http\Requests\Calendarizaciones\StoreTipoPeriodoRequest;
use App\Http\Requests\Calendarizaciones\UpdateTipoPeriodoRequest;
use App\Models\Calendarizaciones\TipoPeriodo;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class TiposPeriodosController extends Controller{

    public function index(){
        $tiposPeriodos = TipoPeriodo::all();
        return Inertia::render('Calendarizaciones/TiposPeriodos/Index', compact('tiposPeriodos'));
    }

    public function create(){
        //
    }

    public function store(StoreTipoPeriodoRequest $request){
        
        try {
 
            TipoPeriodo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'color' => $request->color
            ]);

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de periodo creado correctamente',
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

    public function update(UpdateTipoPeriodoRequest $request, $id){
        
        $tipoPeriodo = TipoPeriodo::find($id);

        try {
 
            $tipoPeriodo->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de periodo modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $tipoPeriodo = TipoPeriodo::find($id);
        
        try {
 
            $tipoPeriodo->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de periodo eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $tipoPeriodo = TipoPeriodo::onlyTrashed()->get();

        return Inertia::render("Calendarizaciones/TiposPeriodos/Trashed", compact('tipoPeriodo'));
    }

    public function restore($id){
        
        $tipoPeriodo = TipoPeriodo::withTrashed()->findOrFail($id);
        $tipoPeriodo->restore();

        return Redirect::route('Calendarizaciones.TiposPeriodos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de periodo restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $tipoPeriodo = TipoPeriodo::withTrashed()->findOrFail($id);
        $tipoPeriodo->forceDelete();

        return Redirect::route('Calendarizaciones.TiposPeriodos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de periodo eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
