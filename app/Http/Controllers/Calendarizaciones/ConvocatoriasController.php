<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;
use App\Models\ServiciosFinancieros\{Servicio};
use App\Models\Calendarizaciones\{Convocatoria, Periodo, TipoConvocatoria};
use App\Http\Requests\Calendarizaciones\StoreConvocatoriaRequest;
use App\Http\Requests\Calendarizaciones\UpdateConvocatoriaRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ConvocatoriasController extends Controller{

    public function index(){
        $convocatorias = Convocatoria::all()->transform(function($convocatoria){
            return [
                'id' => $convocatoria->id,
                'tipoConvocatoria' => $convocatoria->tipoConvocatoria,
                'periodo' => $convocatoria->periodo,
                'servicio' => $convocatoria->servicio,
                'contenido' => $convocatoria->contenido,
            ];
        });
        $periodos = Periodo::all();
        $tiposConvocatorias = TipoConvocatoria::all();
        $servicios = Servicio::all();
        return Inertia::render('Calendarizaciones/Convocatorias/Index', compact('convocatorias', 'periodos', 'tiposConvocatorias', 'servicios'));
    }

    public function create(){
        //
    }

    public function store(StoreConvocatoriaRequest $request){
        
        try {
 
            Convocatoria::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Convocatoria creada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function show(Convocatorias $convocatorias){
        //
    }

    public function edit(Convocatorias $convocatorias){
        //
    }

    public function update(UpdateConvocatoriaRequest $request, $id){
        
        $tipoPeriodo = Convocatoria::find($id);

        try {
 
            $tipoPeriodo->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Convocatoria creada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id){
        $tipoPeriodo = Convocatoria::find($id);
        
        try {
 
            $tipoPeriodo->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Convocatoria eliminada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed(){

        $convocatorias = Convocatoria::onlyTrashed()->get()->transform(function($convocatoria){
            return [
                'id' => $convocatoria->id,
                'tipoConvocatoria' => $convocatoria->tipoConvocatoria,
                'periodo' => $convocatoria->periodo,
                'servicio' => $convocatoria->servicio,
                'contenido' => $convocatoria->contenido,
            ];
        });

        return Inertia::render("Calendarizaciones/Convocatorias/Trashed", compact('convocatorias'));
    }

    public function restore($id){
        
        $convocatoria = Convocatoria::withTrashed()->findOrFail($id);
        $convocatoria->restore();

        return Redirect::route('Calendarizaciones.Convocatorias.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Convocatoria restaurada.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $convocatoria = Convocatoria::withTrashed()->findOrFail($id);
        $convocatoria->forceDelete();

        return Redirect::route('Calendarizaciones.Convocatorias.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Convocatoria eliminada definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
