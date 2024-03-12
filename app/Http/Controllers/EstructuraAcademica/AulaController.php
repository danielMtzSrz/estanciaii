<?php

namespace App\Http\Controllers\EstructuraAcademica;

use App\Http\Controllers\Controller;

use App\Http\Requests\EstructuraAcademica\StoreAulaRequest;
use App\Http\Requests\EstructuraAcademica\UpdateAulaRequest;

use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\Edificio;
use App\Models\EstructuraAcademica\TipoAula;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

class AulaController extends Controller
{

    public function index()
    {
        $aulas = Aula::get()->map(function($aula){
            return $aula->indexMap();
        });
        $edificios = config('staticdata.estructura_academica.edificios');
        $tipos_aula = config('staticdata.estructura_academica.tipos_aulas');

        return Inertia::render('EstructuraAcademica/Aulas/Index', compact('aulas', 'edificios', 'tipos_aula'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'edificio_id' => 'required',
            'tipo_aula_id' => 'required',
            'nombre' => 'required',
            'capacidad' => 'required',
            'horarios' => 'required'
        ]);

        Aula::create($validated_data);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'edificio_id' => 'required',
            'tipo_aula_id' => 'required',
            'nombre' => 'required',
            'capacidad' => 'required',
            'horarios' => 'required'
        ]);

        $aula = Aula::find($id);

        $aula->update($validated_data);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $aula = Aula::find($id);
        
        $aula->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
