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
        $municipio = Municipio::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $municipio = Municipio::find($id);

        $municipio->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $municipio = Municipio::find($id);

        $municipio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
