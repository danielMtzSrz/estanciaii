<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use App\Models\GestionAcademica\Cuatrimestre;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\GestionAcademica\StoreCuatrimestreRequest;
use App\Http\Requests\GestionAcademica\UpdateCuatrimestreRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuatrimestreController extends Controller
{
    public function index()
    {
        $cuatrimestres = Cuatrimestre::orderBy('nombre')->get();
        return Inertia::render('GestionAcademica/Cuatrimestres/Index', compact('cuatrimestres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCuatrimestreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCuatrimestreRequest $request)
    {
            try {
    
                Cuatrimestre::create($request->validated());

                return back()->with(
                    [
                        'backgroundNotification' => 'success',
                        'titleNotification' => '¡Éxito!',
                        'messageNotification' => 'Registro creado correctamente',
                        'lifeNotification' => 5000
                    ]
                );
            } catch (Error $e) {
                dd($e);
            }
        
        }
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GestionAcademica\Cuatrimestre  $cuatrimestre
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\Cuatrimestre  $cuatrimestre
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCuatrimestreRequest  $request
     * @param  \App\Models\GestionAcademica\Cuatrimestre  $cuatrimestre
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCuatrimestreRequest $request, $id)
    {
        try {

            $cuatrimestre = Cuatrimestre::find($id);

            $cuatrimestre->update($request->validated());

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Registro modificado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GestionAcademica\Cuatrimestre  $cuatrimestre
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $cuatrimestre = Cuatrimestre::find($id);

            $cuatrimestre->delete();

            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Registro eliminado correctamente',
                    'lifeNotification' => 5000
                ]
            );
        }catch(Error $e){
            dd($e);
        }
    }

    public function trashed(){

        $cuatrimestres = Cuatrimestre::onlyTrashed()->get()->transform(function($cuatrimestre){
            return [
                'id' => $cuatrimestre->id,
                'nombre'=>$cuatrimestre->nombre,
                'deleted_at' => $cuatrimestre->deleted_at
            ];
        });

        return Inertia::render("GestionAcademica/Cuatrimestres/Trashed", compact('cuatrimestres'));
    }

    public function restore($id){
        
        $cuatrimestre = Cuatrimestre::withTrashed()->findOrFail($id);
        $cuatrimestre->restore();

        return Redirect::route('GestionAcademica.Cuatrimestres.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $cuatrimestre = Cuatrimestre::withTrashed()->findOrFail($id);
        $cuatrimestre->forceDelete();

        return Redirect::route('GestionAcademica.Cuatrimestres.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }

}
