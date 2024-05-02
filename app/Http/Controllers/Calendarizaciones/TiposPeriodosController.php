<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\TipoPeriodo;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Inertia\Inertia;

class TiposPeriodosController extends Controller{

    public function index()
    {
        $tipos_periodo = TipoPeriodo::all();
        
        return Inertia::render('Calendarizaciones/TiposPeriodo/Index', compact('tipos_periodo'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        TipoPeriodo::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $tipo_periodo = TipoPeriodo::find($id);

        $tipo_periodo->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $tipo_periodo = TipoPeriodo::find($id);
        
        $tipo_periodo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
