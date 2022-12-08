<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstructuraAcademica\StoreGrupoRequest;
use App\Http\Requests\EstructuraAcademica\UpdateGrupoRequest;
use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\Grupo;
use App\Models\GestionAcademica\Carrera;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GrupoController extends Controller{

    public function index()
    {
        return Inertia::render('EstructuraAcademica/Grupos/Index', [
            'grupos' => Grupo::with(['carrera', 'aula', 'tutor'])->get(),
            'carreras' => Carrera::select(['id', 'nombre'])->get(),
            'aulas' => Aula::select(['id', 'nombre'])->get(),
            'tutores' => User::select(['id', 'name'])->get()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreGrupoRequest $request)
    {
        try {

            Grupo::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Grupo creado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
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

    public function update(UpdateGrupoRequest $request, $id)
    {
        $grupo = Grupo::find($id);

        try {

            $grupo->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Grupo modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        try {

            $grupo->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Grupo eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed()
    {
        return Inertia::render('EstructuraAcademica/Grupos/Trashed', [
            'grupos' => Grupo::with(['carrera', 'aula', 'tutor'])->onlyTrashed()->get(),
            'carreras' => Carrera::select(['id', 'nombre'])->get(),
            'aulas' => Aula::select(['id', 'nombre'])->get(),
            'tutores' => User::select(['id', 'name'])->get()
        ]);
    }

    public function restore($id)
    {

        $grupo = Grupo::withTrashed()->findOrFail($id);
        $grupo->restore();

        return Redirect::route('EstructuraAcademica.Grupos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Grupo restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id)
    {

        $grupo = Grupo::withTrashed()->findOrFail($id);
        $grupo->forceDelete();

        return Redirect::route('EstructuraAcademica.Grupos.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Grupo eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
