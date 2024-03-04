<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\Asesoria;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Carbon\Carbon;

class AsesoriasController extends Controller
{
    public function index()
    {
        $asesorias = Asesoria::with(['materia', 'user'])->get()->map(function($asesoria){
            return [
                'id' => $asesoria->id,
                'materia' => $asesoria->materia,
                'materia_nombre' => $asesoria->materia->nombre,
                'user' => [
                    'id' => $asesoria->user->id,
                    'nombre' => $asesoria->user->name." ".$asesoria->user->apellido_paterno." ".$asesoria->user->apellido_materno,
                    'profile_photo_path' => $asesoria->user->profile_photo_path
                ],
                'user_profile_photo_path' => $asesoria->user->profile_photo_path,
                'user_nombre' => $asesoria->user->name." ".$asesoria->user->apellido_paterno." ".$asesoria->user->apellido_materno,
                'descripcion' => $asesoria->descripcion,
                'ubicacion' => $asesoria->ubicacion,
                'hora_inicio' => $asesoria->hora_inicio,
                'hora_fin' => $asesoria->hora_fin
            ];
        });

        return Inertia::render('GestionAcademica/Asesorias/Index', compact('asesorias'));
    }

    public function store(Request $request)
    {
        $asesoria = Asesoria::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $asesoria = Asesoria::find($id);

        $asesoria->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $asesoria = Asesoria::find($id);

        $asesoria->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
