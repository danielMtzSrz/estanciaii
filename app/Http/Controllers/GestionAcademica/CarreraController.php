<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use App\Models\GestionAcademica\Carrera;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\GestionAcademica\{StoreCarreraRequest, UpdateCarreraRequest};
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::orderBy('nombre', 'ASC')->get()->transform(function ($carrera){
            return[
                'id'=>$carrera->id,
                'nombre'=>$carrera->nombre,
                'descripcion'=>$carrera->descripcion,
                'estatus'=>$carrera->estatus,
                'tipo_coordinacion_carrera'=>$carrera->tipo_coordinacion_carrera,
                'created_at'=>$carrera->created_at,
                'updated_at'=>$carrera->updated_at
            ];
        });


        return Inertia::render('GestionAcademica/Carreras/Index', compact('carreras'));
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
     * @param  \Illuminate\Http\StoreCarreraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarreraRequest $request)
    {
        try{

            Carrera::create($request->validated());
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
     * @param  \App\Models\GestionAcademica\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show(Carrera $carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCarreraRequest  $request
     * @param  \App\Models\GestionAcademica\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarreraRequest $request, $id)
    {
        try{
            $carrera = Carrera::find($id);
            
            $carrera->update($request->validated());
            return back()->with(
                [
                    'backgroundNotification' => 'success',
                    'titleNotification' => '¡Éxito!',
                    'messageNotification' => 'Registro modificado correctamente',
                    'lifeNotification' => 5000
                ]);
        } catch (Error $e) {
            dd($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GestionAcademica\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
                $carrera = Carrera::find($id);

                $carrera->delete();
                return back()->with(
                    [
                        'titleNotification' => '¡Éxito!',
                        'backgroundNotification' => 'bg-success',
                        'messageNotification' => 'Registro eliminado correctamente',
                        'lifeNotification' => 5000
                    ]
                );
        }
        catch(Error $e){
            dd($e);
        }
    }

    public function trashed(){
        
        $carreras = Carrera::onlyTrashed()->get()->transform(function ($carrera){
            return[  
                'id'=>$carrera->id,
                'nombre'=>$carrera->nombre,
                'descripcion'=>$carrera->descripcion,
                'estatus'=>$carrera->estatus,
                'tipo_coordinacion_carrera'=>$carrera->tipo_coordinacion_carrera,
                'deleted_at'=>$carrera->deleted_at
            ];
        });

        return Inertia::render("GestionAcademica/Carreras/Trashed", compact('carreras'));

    }

    public function restore($id){
        
        $carrera = Carrera::withTrashed()->findOrFail($id);
        $carrera->restore();

        return Redirect::route('GestionAcademica.Carreras.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $carrera = Carrera::withTrashed()->findOrFail($id);
        $carrera->forceDelete();

        return Redirect::route('GestionAcademica.Carreras.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
