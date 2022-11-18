<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstructuraAcademica\StoreEdificioRequest;
use App\Http\Requests\EstructuraAcademica\UpdateEdificioRequest;
use App\Models\EstructuraAcademica\Edificio;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EdificioController extends Controller{

    public function index(){

        return Inertia::render('EstructuraAcademica/Edificios/Index', [
            'edificios' => Edificio::get()
        ]);

    }

    public function create()
    {
        //
    }

    public function store(StoreEdificioRequest $request)
    {
        try {

            Edificio::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Edificio creado correctamente',
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

    public function update(UpdateEdificioRequest $request, $id)
    {
        $edificio = Edificio::find($id);

        try {

            $edificio->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Edificio modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        $edificio = Edificio::find($id);

        try {

            $edificio->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Edificio eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed()
    {
        return Inertia::render('EstructuraAcademica/Edificios/Trashed', [
            'edificios' => Edificio::onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {

        $edificio = Edificio::withTrashed()->findOrFail($id);
        $edificio->restore();

        return Redirect::route('EstructuraAcademica.Edificios.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Edificio restaurado correctamente.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id)
    {

        $edificio = Edificio::withTrashed()->findOrFail($id);
        $edificio->forceDelete();

        return Redirect::route('EstructuraAcademica.Edificio.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Edificio eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
