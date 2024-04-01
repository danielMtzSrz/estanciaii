<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

use Inertia\Inertia;

class PanelPrincipalController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['aula', 'carrera', 'tutor'])->get()->map(function($grupo){
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

        return Inertia::render('Dashboard', compact('grupos'));
    }
}
