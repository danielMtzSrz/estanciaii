<?php

namespace App\Http\Controllers\Calendarizaciones;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\{Periodo, TipoPeriodo};

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Inertia\Inertia;

class PeriodosController extends Controller{

    public function index()
    {
        $periodos = Periodo::with('tipoPeriodo')
            ->get()
            ->map(function($periodo){
                return $periodo->indexMap();
            });
        $tipoperiodos = TipoPeriodo::orderBy('nombre', 'ASC')->get();
        
        return Inertia::render('Calendarizaciones/Periodos/Index', compact('periodos', 'tipoperiodos'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'tipo_periodo_id' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'periodo_activo' => 'required'
        ]);

        Periodo::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'tipo_periodo_id' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'periodo_activo' => 'required'
        ]);

        $periodo = Periodo::find($id);
 
        $periodo->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $periodo = Periodo::find($id);
 
        $periodo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
