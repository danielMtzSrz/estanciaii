<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use App\Models\GestionAcademica\MapaCurricular;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\GestionAcademica\StoreMapaCurricularRequest;
use App\Http\Requests\GestionAcademica\UpdateMapaCurricularRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapaCurricularController extends Controller
{
    public function index()
    {
        $mapasCurriculares = MapaCurricular::orderBy('clave_mapa_curricular')->get();
        return Inertia::render('GestionAcademica/MapasCurriculares/Index', compact('mapasCurriculares'));
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
     * @param  \Illuminate\Http\StoreMapaCurricularRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMapaCurricularRequest $request)
    {
        try {
 
            MapaCurricular::create($request->validated());

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
     * @param  \App\Models\GestionAcademica\MapaCurricular  $mapaCurricular
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\MapaCurricular  $mapaCurricular
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateMapaCurricularRequest  $request
     * @param  \App\Models\GestionAcademica\MapaCurricular  $mapaCurricular
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMapaCurricularRequest $request, $id)
    {
        try {

            $mapaCurricular = MapaCurricular::find($id);

            $mapaCurricular->update($request->validated());

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
     * @param  \App\Models\GestionAcademica\MapaCurricular  $mapaCurricular
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $mapaCurricular = MapaCurricular::find($id);

            $mapaCurricular->delete();

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

        $mapasCurriculares = MapaCurricular::onlyTrashed()->get()->transform(function($mapaCurricular){
            return [
                'id' => $mapaCurricular->id,
                'clave_mapa_curricular'=>$mapaCurricular->clave_mapa_curricular,
                'total_cuatrimestres'=>$mapaCurricular->total_cuatrimestres,
                'total_horas'=>$mapaCurricular->total_horas,
                'total_creditos'=>$mapaCurricular->total_creditos,
                'total_materias'=>$mapaCurricular->total_materias,
                'duracion'=>$mapaCurricular->duracion,
                'vigencia'=>$mapaCurricular->vigencia,
                'fecha_revision'=>$mapaCurricular->fecha_revision,
                'created_at' => $mapaCurricular->created_at,
                'updated_at' => $mapaCurricular->updated_at,
                'deleted_at' => $mapaCurricular->deleted_at
            ];
        });

        return Inertia::render("GestionAcademica/MapasCurriculares/Trashed", compact('mapasCurriculares'));
    }

    public function restore($id){
        
        $mapaCurricular = MapaCurricular::withTrashed()->findOrFail($id);
        $mapaCurricular->restore();

        return Redirect::route('GestionAcademica.MapasCurriculares.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $mapaCurricular = MapaCurricular::withTrashed()->findOrFail($id);
        $mapaCurricular->forceDelete();

        return Redirect::route('GestionAcademica.MapasCurriculares.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }
}
