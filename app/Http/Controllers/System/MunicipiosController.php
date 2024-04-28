<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Domicilios\Municipio;

use Illuminate\Http\Request;

use Inertia\Inertia;

class MunicipiosController extends Controller
{
    public function index()
    {
        $municipios = Municipio::get()->map(function($municipios){
            return $municipios->indexMap();
        });

        return Inertia::render("System/Municipios/Index", compact('municipios'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'estado_id' => 'required',
            'nombre' => 'required'
        ]);

        $municipio = Municipio::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'estado_id' => 'required',
            'nombre' => 'required'
        ]);
        
        $municipio = Municipio::find($id);

        $municipio->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $municipio = Municipio::find($id);

        $municipio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
