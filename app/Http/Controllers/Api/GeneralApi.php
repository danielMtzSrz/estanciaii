<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class GeneralApi extends Controller
{
    public function Generos()
    {
        $data = config('staticdata.informacion_personal.generos');

        return response()->json($data);
    }

    public function TiposSangre()
    {
        $data = config('staticdata.informacion_personal.tipos_sangre');

        return response()->json($data);
    }

    public function EstadosCiviles()
    {
        $data = config('staticdata.informacion_personal.estados_civiles');

        return response()->json($data);
    }
}
