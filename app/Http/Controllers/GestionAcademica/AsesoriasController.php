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
        $validated_data = $request->validate([
            "materia_id" => 'required',
            "user_id" => 'required',
            "descripcion" => "required",
            "ubicacion" => "required",
            "hora_inicio" => "required",
            "hora_fin" => "required"
        ]);

        $validated_data['hora_inicio'] = $this->horasMap($validated_data['hora_inicio']);
        $validated_data['hora_fin'] = $this->horasMap($validated_data['hora_fin']);

        $asesoria = Asesoria::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function horasMap($hora)
    {
        return (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $hora)) 
                    ? Carbon::now()->isDST() ? Carbon::parse($hora)->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($hora)->timezone('America/Monterrey')->format('H:i')
                    : $hora;
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
