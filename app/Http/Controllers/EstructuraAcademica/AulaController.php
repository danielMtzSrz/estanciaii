<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstructuraAcademica\StoreAulaRequest;
use App\Http\Requests\EstructuraAcademica\UpdateAulaRequest;
use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\Edificio;
use App\Models\EstructuraAcademica\TipoAula;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AulaController extends Controller
{

    public function index()
    {
        $aulas = Aula::get()->map(function($aula){
            return $aula->indexMap();
        });
        // $aulas = Aula::with(['edificio', 'tipoAula'])->get();
        $edificios = config('staticdata.estructura_academica.edificios');
        $tipos_aula = config('staticdata.estructura_academica.tipos_aulas');

        return Inertia::render('EstructuraAcademica/Aulas/Index', compact('aulas', 'edificios', 'tipos_aula'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Aula::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $aula = Aula::find($id);

        $aula->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $aula = Aula::find($id);

        try {

            $aula->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Aula eliminada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed()
    {
        return Inertia::render('EstructuraAcademica/Aulas/Trashed', [
            'aulas' => Aula::with(['edificio', 'tipoAula'])->onlyTrashed()->get(),
            'edificios' => Edificio::select(['id', 'nombre'])->get(),
            'tiposAulas' => TipoAula::select(['id', 'nombre'])->get()
        ]);
    }

    public function restore($id)
    {

        $aula = Aula::withTrashed()->findOrFail($id);
        $aula->restore();

        return Redirect::route('EstructuraAcademica.Aulas.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Aula restaurada.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id)
    {

        $aula = Aula::withTrashed()->findOrFail($id);
        $aula->forceDelete();

        return Redirect::route('EstructuraAcademica.Aulas.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Aula eliminada definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
