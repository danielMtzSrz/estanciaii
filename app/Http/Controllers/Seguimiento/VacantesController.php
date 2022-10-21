<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Seguimiento\Vacantes;
use App\Models\System\Empresas;
use App\Http\Requests\Seguimiento\Vacantes\{StoreVacantes, UpdateVacantes};
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class VacantesController extends Controller{

    public function index(){

        session(['breadcrumbItems' => [
            [
                'label' => 'Vacantes',
                'url' => route('vacantes.index'),

            ]
        ]]);

        $vacantes = Vacantes::all()->transform(function($vacante){
            return [
                'id' => $vacante->id,
                'name' => $vacante->name,
                'empresa' => $vacante->empresa,
                'contenido' => $vacante->contenido,
                'imagen' => $vacante->imagen
            ];
        });
        $empresas = Empresas::orderBy('name', 'asc')->get();
        return Inertia::render('Seguimiento/Vacantes/Index', compact('vacantes', 'empresas'));
    }

    public function create()
    {
        //
    }

    public function store(StoreVacantes $request){
        // dd($request->validated());
        try {
            // Guardar registro
            $vacantes = Vacantes::create($request->validated());

            // Imagen
            if($request->file('imagen')){
                $vacantes->imagen = $request->file('imagen')->store('vacantes', 'public');
                $vacantes->save();
            }

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'Vacante creada correctamente',
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

    public function update(UpdateVacantes $request, $id){

        $vacante = Vacantes::find($id);

        try {

            $vacante->update($request->validated());

            if($request->file('imagen')) {
                Storage::disk('public')->delete($vacante->imagen);
                $vacante->imagen = $request->file('imagen')->store('vacantes', 'public');
                $vacante->save();
            }

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'Vacante modificada correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function destroy($id){

        $vacante = Vacantes::find($id);

        // Eliminación de la imagen
        Storage::disk('public')->delete($vacante->imagen);

        $vacante->delete();

        return back()->with(
            [
                'summary' => '¡Éxito!',
                'severity' => 'success',
                'detail' => 'Vacante eliminada correctamente',
                'life' => 5000
            ]
        );
    }
}
