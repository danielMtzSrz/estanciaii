<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Domicilios\Estado;

use Illuminate\Http\Request;

use Inertia\Inertia;

class EstadosController extends Controller
{
    public function index()
    {
        $estados = Estado::get()->map(function($estado){
            return $estado->indexMap();
        });

        return Inertia::render("System/Estados/Index", compact('estados'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'pais_id' => 'required',
            'nombre' => 'required'
        ]);

        $estado = Estado::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'pais_id' => 'required',
            'nombre' => 'required'
        ]);

        $estado = Estado::find($id);

        $estado->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $estado = Estado::find($id);

        $estado->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
