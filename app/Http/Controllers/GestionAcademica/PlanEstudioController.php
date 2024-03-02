<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\PlanEstudio;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanEstudioController extends Controller
{
    public function index()
    {
        $planes_estudio = PlanEstudio::get();

        return Inertia::render('GestionAcademica/PlanesEstudios/Index', compact('planes_estudio'));
    }

    public function store(Request $request)
    {
        PlanEstudio::create($request->validated());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $planEstudio = PlanEstudio::find($id);
            
        $planEstudio->update($request->validated());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $planEstudio = PlanEstudio::find($id);

        $planEstudio->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
