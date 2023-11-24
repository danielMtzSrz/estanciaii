<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Vacantes\TipoAnuncio;

use Illuminate\Http\Request;

use Inertia\Inertia;

class TiposAnunciosController extends Controller
{
    public function index()
    {
        $tipos_anuncios = TipoAnuncio::get()->map(function($tipo_anuncio){
            return $tipo_anuncio->indexMap();
        });

        return Inertia::render("System/Vacantes/TiposAnuncios/Index", compact('tipos_anuncios'));
    }

    public function store(Request $request)
    {
        $tipo_anuncio = TipoAnuncio::create($request->all());

        // Cargar imagen
        if($request->file('imagen')){
            $tipo_anuncio->imagen = $request->file('imagen')->store('imagen', 'public');
            $tipo_anuncio->save();
        }

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $tipo_anuncio = TipoAnuncio::find($id);

        $tipo_anuncio->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $tipo_anuncio = TipoAnuncio::find($id);

        $tipo_anuncio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
