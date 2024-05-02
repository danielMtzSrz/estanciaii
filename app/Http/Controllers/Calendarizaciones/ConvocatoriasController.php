<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\Convocatoria;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Inertia\Inertia;

class ConvocatoriasController extends Controller {

    public function index()
    {
        $convocatorias = Convocatoria::get()->map(function($convocatoria){
            return $convocatoria->indexMap();
        });

        return Inertia::render('Calendarizaciones/Convocatorias/Index', compact('convocatorias'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'periodo_id' => 'required',
            'tipo_convocatoria_id' => 'required',
            'contenido' => 'required'
        ]);

        Convocatoria::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
        
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'periodo_id' => 'required',
            'tipo_convocatoria_id' => 'required',
            'contenido' => 'required'
        ]);

        $tipoPeriodo = Convocatoria::find($id);
 
        $tipoPeriodo->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $tipoPeriodo = Convocatoria::find($id);
 
        $tipoPeriodo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
