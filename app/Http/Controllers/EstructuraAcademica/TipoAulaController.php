<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstructuraAcademica\StoreTipoAulaRequest;
use App\Http\Requests\EstructuraAcademica\UpdateTipoAulaRequest;
use App\Models\EstructuraAcademica\TipoAula;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TipoAulaController extends Controller{

    public function index(){

        return Inertia::render('EstructuraAcademica/TiposAulas/Index', [
            'tiposAulas' => TipoAula::get()
        ]);

    }

    public function create()
    {
        //
    }

    public function store(StoreTipoAulaRequest $request)
    {
        try {

            TipoAula::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de aula creado correctamente',
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

    public function update(UpdateTipoAulaRequest $request, $id)
    {
        $tipoAula = TipoAula::find($id);

        try {

            $tipoAula->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de aula modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        $tipoAula = TipoAula::find($id);

        try {

            $tipoAula->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Tipo de aula eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed()
    {
        return Inertia::render('EstructuraAcademica/TiposAulas/Trashed', [
            'tiposAulas' => TipoAula::onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {

        $tipoAula = TipoAula::withTrashed()->findOrFail($id);
        $tipoAula->restore();

        return Redirect::route('EstructuraAcademica.TiposAulas.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de aula restaurado correctamente.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id)
    {

        $tipoAula = TipoAula::withTrashed()->findOrFail($id);
        $tipoAula->forceDelete();

        return Redirect::route('EstructuraAcademica.TiposAulas.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Tipo de aula eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
