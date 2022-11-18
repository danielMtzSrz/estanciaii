<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstructuraAcademica\StoreAulaReservacionRequest;
use App\Http\Requests\EstructuraAcademica\UpdateAulaReservacionRequest;
use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\AulaReservacion;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AulaReservacionController extends Controller{

    public function index(){

        return Inertia::render('EstructuraAcademica/AulasReservacion/Index', [
            'aulasReservacion' => AulaReservacion::with(['aula', 'solicitante'])->get(),
            'aulas' => Aula::select(['id', 'nombre'])->get(),
            'solicitantes' => User::select(['id', 'name'])->get()
        ]);

    }

    public function create()
    {
        //
    }

    public function store(StoreAulaReservacionRequest $request)
    {
        try {

            AulaReservacion::create($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Reservación creada correctamente',
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

    public function update(UpdateAulaReservacionRequest $request, $id)
    {
        $aulaReservacion = AulaReservacion::find($id);

        try {

            $aulaReservacion->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Reservación modificada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function destroy($id)
    {
        $aulaReservacion = AulaReservacion::find($id);

        try {

            $aulaReservacion->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Reservación eliminada correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    public function trashed()
    {
        return Inertia::render('EstructuraAcademica/AulasReservacion/Trashed', [
            'aulasReservacion' => AulaReservacion::with(['aula', 'solicitante'])->onlyTrashed()->get(),
            'aulas' => Aula::select(['id', 'nombre'])->get(),
            'solicitantes' => User::select(['id', 'name'])->get()
        ]);
    }

    public function restore($id)
    {

        $aulaReservacion = AulaReservacion::withTrashed()->findOrFail($id);
        $aulaReservacion->restore();

        return Redirect::route('EstructuraAcademica.AulasReservacion.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Reservación restaurada.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id)
    {

        $aulaReservacion = AulaReservacion::withTrashed()->findOrFail($id);
        $aulaReservacion->forceDelete();

        return Redirect::route('EstructuraAcademica.AulasReservacion.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Reservación eliminada definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
