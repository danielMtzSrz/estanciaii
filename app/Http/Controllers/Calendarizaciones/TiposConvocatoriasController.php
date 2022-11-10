<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\Calendarizaciones\TipoConvocatoria;
use App\Http\Requests\Calendarizaciones\StoreTiposConvocatoriasRequest;
use App\Http\Requests\Calendarizaciones\UpdateTiposConvocatoriasRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class TiposConvocatoriasController extends Controller{

    public function index(){
        $tiposConvocatorias = TipoConvocatoria::all();
        return Inertia::render('Calendarizaciones/TiposConvocatorias/Index', compact('tiposConvocatorias'));
    }

    public function create(){
        //
    }

    public function store(StoreTiposConvocatoriasRequest $request){
        
        try {
 
            TipoConvocatoria::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de convocatoria creada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function show(TipoConvocatoria $tipoConvocatoria){
        //
    }

    public function edit(TipoConvocatoria $tipoConvocatoria){
        //
    }

    public function update(UpdateTiposConvocatoriasRequest $request, $id){
        
        $tipoConvocatoria = TipoConvocatoria::find($id);

        try {
 
            $tipoConvocatoria->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de convocatoria modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $tipoConvocatoria = TipoConvocatoria::find($id);
        
        try {
 
            $tipoConvocatoria->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de convocatoria eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $tipoConvocatoria = TipoConvocatoria::onlyTrashed()->get();

        return Inertia::render("Calendarizaciones/TiposConvocatorias/Trashed", compact('tipoConvocatoria'));
    }

    public function restore($id){
        
        $tipoConvocatoria = TipoConvocatoria::withTrashed()->findOrFail($id);
        $tipoConvocatoria->restore();

        return Redirect::route('Calendarizaciones.TipoConv.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de convocatoria restaurada.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $tipoConvocatoria = TipoConvocatoria::withTrashed()->findOrFail($id);
        $tipoConvocatoria->forceDelete();

        return Redirect::route('Calendarizaciones.TipoConv.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de convocatoria eliminada definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
