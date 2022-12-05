<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Seguimiento\Anuncios;
use App\Models\Empresas;
use App\Http\Requests\Seguimiento\Anuncios\{StoreAnuncios, UpdateAnuncios};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class AnunciosController extends Controller{


    public function index(){

        session(['breadcrumbItems' => [
            [
                'label' => 'Anuncios',
                'url' => route('anuncios.index'),

            ]
        ]]);

        $anuncios = Anuncios::all()->transform(function($anuncio){
            return [
                'id' => $anuncio->id,
                'name' => $anuncio->name,
                'empresa' => $anuncio->empresa,
                'contenido' => $anuncio->contenido,
                'imagen' => $anuncio->imagen
            ];
        });
        $empresas = Empresas::orderBy('nombre_empresa', 'asc')->get();
        return Inertia::render('Seguimiento/Anuncios/Index', compact('anuncios', 'empresas'));
    }

    public function create()
    {
        //
    }

    public function store(StoreAnuncios $request){
        // dd($request->validated());
        try {
            // Guardar registro
            $anuncios = Anuncios::create($request->validated());

            // Imagen
            if($request->file('imagen')){
                $anuncios->imagen = $request->file('imagen')->store('anuncios', 'public');
                $anuncios->save();
            }

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'Anuncio creado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdateAnuncios $request, $id){

        $anuncio = Anuncios::find($id);

        try {

            $anuncio->update($request->validated());

            if($request->file('imagen')) {
                Storage::disk('public')->delete($anuncio->imagen);
                $anuncio->imagen = $request->file('imagen')->store('anuncios', 'public');
                $anuncio->save();
            }

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'Anuncio modificado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function destroy($id){

        $anuncio = Anuncios::find($id);

        // Eliminación de la imagen
        Storage::disk('public')->delete($anuncio->imagen);

        $anuncio->delete();

        return back()->with(
            [
                'summary' => '¡Éxito!',
                'severity' => 'success',
                'detail' => 'Anuncio eliminado correctamente',
                'life' => 5000
            ]
        );
    }
}
