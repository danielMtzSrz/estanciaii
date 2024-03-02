<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\Carrera;

class CarrerasApi extends Controller
{
    public function Carreras()
    {
        $data = Carrera::orderBy('nombre', 'asc')->get();

        return response()->json($data);
    }

    public function Turnos()
    {
        $data = config('staticdata.gestion_academica.turnos');

        return response()->json($data);
    }
}
