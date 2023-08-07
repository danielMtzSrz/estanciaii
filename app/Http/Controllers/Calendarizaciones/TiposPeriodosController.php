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

    public function index()
    {
        $tiposPeriodos = TipoPeriodo::all();
        return Inertia::render('Calendarizaciones/TiposPeriodos/Index', compact('tiposPeriodos'));
    }

    public function store(StoreTipoPeriodoRequest $request)
    {
        TipoPeriodo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(UpdateTipoPeriodoRequest $request, $id)
    {
        $tipoPeriodo = TipoPeriodo::find($id);

        $tipoPeriodo->update($request->validated());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $tipoPeriodo = TipoPeriodo::find($id);
        
        $tipoPeriodo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
        
    }

    public function trashed()
    {
        $tipoPeriodo = TipoPeriodo::onlyTrashed()->get();

        return Inertia::render("Calendarizaciones/TiposPeriodos/Trashed", compact('tipoPeriodo'));
    }

    public function restore($id)
    {   
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

    public function forceDestroy($id)
    {    
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
