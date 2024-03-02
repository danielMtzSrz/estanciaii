<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\MapaCurricular;

class MapasCurricularesApi extends Controller
{
    public function MapasCurriculares()
    {
        $data = MapaCurricular::get();

        return response()->json($data);
    }
}
