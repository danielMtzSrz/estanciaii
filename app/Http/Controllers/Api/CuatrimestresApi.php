<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CuatrimestresApi extends Controller
{
    public function Cuatrimestres()
    {
        $data = config('staticdata.gestion_academica.cuatrimestres');

        return response()->json($data);
    }
}
