<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Domicilios\Pais;

use Illuminate\Http\Request;

use Inertia\Inertia;

class PaisesController extends Controller
{
    public function index()
    {
        $paises = Pais::get();

        return Inertia::render("System/Paises/Index", compact('paises'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nombre' => "required",
            'nacionalidad' => "required"
        ]);

        $pais = Pais::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'nombre' => "required",
            'nacionalidad' => "required"
        ]);

        $pais = Pais::find($id);

        $pais->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);

        $pais->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
