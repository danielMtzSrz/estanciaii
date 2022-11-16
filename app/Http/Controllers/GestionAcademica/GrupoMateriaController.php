<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;
use App\Http\Requests\GestionAcademica\StoreGrupoMateriaRequest;
use App\Http\Requests\GestionAcademica\UpdateGrupoMateriaRequest;
use App\Models\GestionAcademica\GrupoMateria;
use App\Models\GestionAcademica\CargaAcademica;
use App\Models\Persona\Usuario;
use App\Models\Persona\Personal;
use App\Models\GestionAcademica\Materia;
use App\Models\Calendarizaciones\Horario;
use App\Models\EstructuraAcademica\Grupo;
use App\Models\Calendarizaciones\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GrupoMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gruposMaterias = GrupoMateria::orderBy('nombre', 'ASC')->get()->transform(function ($grupoMateria){
            return[
                'id'=>$grupoMateria->id,
                'profesor'=>$grupoMateria->profesor,
                'materia'=>$grupoMateria->materia,
                'horario'=>$grupoMateria->horario,
                'grupo'=>$grupoMateria->grupo,
                'periodo'=>$grupoMateria->periodo,
                'created_at'=>$grupoMateria->created_at,
                'updated_at'=>$grupoMateria->updated_at
            ];
        });

        $profesores = Personal::orderBy('usuario_id', 'ASC')->get()->transform( function ($profesor){
            return[
                'id'=>$profesor->id,
                'usuario'=>$profesor->usuario,
                'foto'=>$profesor->foto
            ];
        });
        
        $materias = Materia::orderBy('nombre', 'ASC')->get();
        $horarios = Horario::orderBy('aula_id', 'ASC')->get();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GestionAcademica\GrupoMateria  $grupoMateria
     * @return \Illuminate\Http\Response
     */
    public function show(GrupoMateria $grupoMateria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GestionAcademica\GrupoMateria  $grupoMateria
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoMateria $grupoMateria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GestionAcademica\GrupoMateria  $grupoMateria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoMateria $grupoMateria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GestionAcademica\GrupoMateria  $grupoMateria
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoMateria $grupoMateria)
    {
        //
    }
}
