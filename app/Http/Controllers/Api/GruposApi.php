<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

class GruposApi extends Controller
{
    public function Grupos()
    {
        $data = Grupo::get();

        return response()->json($data);
    }

    public function PanelPrincipal($id = null)
    {
        $grupos = null;
        if($id == 'null'){
            $grupos = Grupo::with(['aula', 'carrera', 'tutor'])
            ->get()
            ->map(function($grupo){
                return [
                    'id' => $grupo->id,
                    'carrera' => $grupo->carrera,
                    'carrera_nombre' => $grupo->carrera->nombre,
                    'edificio' => $grupo->aula->edificio(),
                    'edificio_nombre' => $grupo->aula->edificio()["nombre"],
                    'aula' => $grupo->aula,
                    'aula_nombre' => $grupo->aula->nombre,
                    'tutor' => [
                        'id' => $grupo->tutor->id,
                        'nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                        'profile_photo_path' => $grupo->tutor->profile_photo_path
                    ],
                    'horarios' => $grupo->horarios,
                    'tutor_nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                    'nombre' => $grupo->nombre,
                    'turno' => $grupo->turno(),
                    'turno_nombre' => $grupo->turno()["nombre"]
                ];
            });
        }else{
            $grupos = Grupo::with(['aula', 'carrera', 'tutor'])
            ->where('periodo_id', $id)
            ->get()
            ->map(function($grupo){
                return [
                    'id' => $grupo->id,
                    'carrera' => $grupo->carrera,
                    'carrera_nombre' => $grupo->carrera->nombre,
                    'edificio' => $grupo->aula->edificio(),
                    'edificio_nombre' => $grupo->aula->edificio()["nombre"],
                    'aula' => $grupo->aula,
                    'aula_nombre' => $grupo->aula->nombre,
                    'tutor' => [
                        'id' => $grupo->tutor->id,
                        'nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                        'profile_photo_path' => $grupo->tutor->profile_photo_path
                    ],
                    'horarios' => $grupo->horarios,
                    'tutor_nombre' => $grupo->tutor->name." ".$grupo->tutor->apellido_paterno." ".$grupo->tutor->apellido_materno,
                    'nombre' => $grupo->nombre,
                    'turno' => $grupo->turno(),
                    'turno_nombre' => $grupo->turno()["nombre"]
                ];
            });
        }

        return response()->json($grupos);
    }
}
