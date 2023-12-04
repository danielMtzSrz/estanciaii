<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\TipoConvocatoria;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Inertia\Inertia;

class TiposConvocatoriasController extends Controller{

    public function index()
    {
        $tipos_convocatoria = TipoConvocatoria::get();

        return Inertia::render('Calendarizaciones/TiposConvocatorias/Index', compact('tipos_convocatoria'));
    }

    public function store(Request $request)
    {
        TipoConvocatoria::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $tipoConvocatoria = TipoConvocatoria::find($id);

        $tipoConvocatoria->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $tipoConvocatoria = TipoConvocatoria::find($id);
        
        $tipoConvocatoria->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
