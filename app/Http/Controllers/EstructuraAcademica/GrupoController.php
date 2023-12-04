<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Http\Requests\EstructuraAcademica\StoreGrupoRequest;
use App\Http\Requests\EstructuraAcademica\UpdateGrupoRequest;

use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\Grupo;
use App\Models\GestionAcademica\Carrera;
use App\Models\User;

use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GrupoController extends Controller{

    public function index()
    {

        $grupoos = Grupo::with(['carrera', 'aula', 'tutor'])->get();
        $carreras = Carrera::select(['id', 'nombre'])->get();
        $aulas = Aula::select(['id', 'nombre'])->get();
        $tutores = User::select(['id', 'name'])->get();

        return Inertia::render('EstructuraAcademica/Grupos/Index', compact('grupos','carreras','aulas','tutores'));
    }

    public function store(StoreGrupoRequest $request)
    {
        Grupo::create($request->validated());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(UpdateGrupoRequest $request, $id)
    {
        $grupo = Grupo::find($id);

        $grupo->update($request->validated());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $grupo = Grupo::find($id);


        $grupo->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
