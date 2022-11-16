<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\GestionAcademica\Materia;
use App\Models\EstructuraAcademica\Academia;
use App\Models\GestionAcademica\Cuatrimestre;
use App\Models\GestionAcademica\PlanEstudio;
use App\Http\Requests\GestionAcademica\StoreMateriaRequest;
use App\Http\Requests\GestionAcademica\UpdateMateriaRequest;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = Materia::orderBy('nombre', 'ASC')->get()->transform(function ($materia){
            return[
                'id'=>$materia->id,
                "cuatrimestre"=>$materia->cuatrimestre ? $materia->cuatrimestre : NULL,
                "nombre"=>$materia->nombre,
                "planEstudio"=>$materia->planEstudio ? $materia->planEstudio : NULL,
                'created_at'=>$materia->created_at,
                'updated_at'=>$materia->updated_at
            ];
        });

        $cuatrimestres = Cuatrimestre::orderBy('nombre', 'ASC')->get();
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
        return Inertia::render('GestionAcademica/Materias/Index', compact('materias','cuatrimestres', 'planesEstudios'));
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
     * @param  \Illuminate\Http\StoreMateriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMateriaRequest $request)
    {
        try{

            Materia::create($request->validated());
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
     * @param  \App\Models\GestionAcademica\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(Materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateMateriaRequest  $request
     * @param  \App\Models\GestionAcademica\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMateriaRequest $request, $id)
    {
        try{
            $materia = Materia::find($id);
            
            $materia->update($request->validated());
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
     * @param  \App\Models\GestionAcademica\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $materia = Materia::find($id);
            
            $materia->delete();
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

    public function trashed(){
        
        $materias = Materia::onlyTrashed()->get()->transform(function ($materia){
            return[  
                'id'=>$materia->id,
                "academia"=>$materia->academia ? $materia->academia : NULL,
                "cuatrimestre"=>$materia->cuatrimestre ? $materia->cuatrimestre : NULL,
                "nombre"=>$materia->nombre,
                "planEstudio"=>$materia->planEstudio ? $materia->planEstudio : NULL,
                'deleted_at'=>$materia->deleted_at
            ];
        });

        return Inertia::render("GestionAcademica/Materias/Trashed", compact('materias'));

    }

    public function restore($id){
        
        $materia = Materia::withTrashed()->findOrFail($id);
        $materia->restore();

        return Redirect::route('GestionAcademica.Materias.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro restaurado.',
                'lifeNotification' => 5000
            ]
        );
    }

    public function forceDestroy($id){
        
        $materia = Materia::withTrashed()->findOrFail($id);
        $materia->forceDelete();

        return Redirect::route('GestionAcademica.Materias.trashed')->with(
            [
                'titleNotification' => '¡Éxito!',
                'backgroundNotification' => 'success',
                'messageNotification' => 'Registro eliminado definitivamente.',
                'lifeNotification' => 5000
            ]
        );
    }

}
