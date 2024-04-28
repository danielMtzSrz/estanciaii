<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Vacantes\Anuncio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class AnunciosController extends Controller
{
    public function index()
    {      
        $anuncios = Anuncio::get();
        $anuncios = Anuncio::get()->map(function($anuncio){
            return $anuncio->indexMap();
        });

        return Inertia::render("System/Vacantes/Anuncios/Index", compact('anuncios'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            "tipo_anuncio_id" => 'required',
            "empresa_id" => 'required',
            "titulo" => 'required',
            "contenido" => 'required',
            "imagen" => 'required'
        ]);

        $anuncio = Anuncio::create($validated_data);

        // Cargar imagen
        if($request->file('imagen')){
            $anuncio->imagen = $request->file('imagen')->store('System/Anuncios', 'public');
            $anuncio->save();
        }

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            "tipo_anuncio_id" => 'required',
            "empresa_id" => 'required',
            "titulo" => 'required',
            "contenido" => 'required',
            "imagen" => 'required'
        ]);

        $anuncio = Anuncio::find($id);
        
        if($request->file('imagen')){
            Storage::disk('public')->delete($anuncio->imagen);
        }

        $anuncio->update($validated_data);

        if($request->file('imagen')) {
            $anuncio->imagen = $request->file('imagen')->store('System/Anuncios', 'public');
            $anuncio->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $anuncio = Anuncio::find($id);

        Storage::disk('public')->delete($anuncio->imagen);

        $anuncio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
