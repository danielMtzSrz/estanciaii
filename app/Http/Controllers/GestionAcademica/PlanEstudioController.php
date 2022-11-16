<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use App\Models\GestionAcademica\PlanEstudio;
use App\Models\GestionAcademica\Carrera;
use App\Models\GestionAcademica\MapaCurricular;
use App\Http\Requests\GestionAcademica\StorePlanEstudioRequest;
use App\Http\Requests\GestionAcademica\UpdatePlanEstudioRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Request;


class PlanEstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planesEstudios = PlanEstudio::orderBy('carrera_id', 'ASC')->get()->transform(function ($planEstudio){
            return[
                'id'=>$planEstudio->id,
                'carrera'=>$planEstudio->carrera ? $planEstudio->carrera : NULL,
                'mapaCurricular'=>$planEstudio->mapaCurricular ? $planEstudio->mapaCurricular : NULL,
                'estatus'=>$planEstudio->estatus,
                'created_at'=>$planEstudio->created_at,
                'updated_at'=>$planEstudio->updated_at
            ];
        });
        $carreras = Carrera::orderBy('nombre', 'ASC')->get();
        $mapasCurriculares= MapaCurricular::orderBy('clave_mapa_curricular', 'ASC')->get();


        return Inertia::render('GestionAcademica/PlanesEstudios/Index', compact('planesEstudios','carreras', 'mapasCurriculares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StorePlanEstudioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanEstudioRequest $request)
    {
        try{

            PlanEstudio::create($request->validated());
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
     * @param  \App\Models\GestionAcademica\PlanEstudio  $planEstudio
     * @return \Illuminate\Http\Response
     */

    public function show(PlanEstudio $planEstudio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\PlanEstudio  $planEstudio
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanEstudio $planEstudio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdatePlanEstudioRequest  $request
     * @param  \App\Models\GestionAcademica\PlanEstudio  $planEstudio
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePlanEstudioRequest $request, $id)
    {
        try{
            $planEstudio = PlanEstudio::find($id);
            
            $planEstudio->update($request->validated());
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
     * @param  \App\Models\GestionAcademica\PlanEstudio  $planEstudio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
        try{
            $planEstudio = PlanEstudio::find($id);

            $planEstudio->delete();
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
        
        $planesEstudios = PlanEstudio::onlyTrashed()->get()->transform(function ($planEstudio){
            return[  
                'id'=>$planEstudio->id,
                'carrera'=>$planEstudio->carrera ? $planEstudio->carrera : NULL,
                'mapaCurricular'=>$planEstudio->mapaCurricular ? $planEstudio->mapaCurricular : NULL,
                'estatus'=>$planEstudio->estatus,
                'deleted_at'=>$planEstudio->deleted_at
            ];
        });

        return Inertia::render("GestionAcademica/PlanesEstudios/Trashed", compact('planesEstudios'));

    }

    public function restore($id){
        
        $planEstudio = PlanEstudio::withTrashed()->findOrFail($id);
        $planEstudio->restore();

        return Redirect::route('GestionAcademica.PlanesEstudios.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $planEstudio = PlanEstudio::withTrashed()->findOrFail($id);
        $planEstudio->forceDelete();

        return Redirect::route('GestionAcademica.PlanesEstudios.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }

}
