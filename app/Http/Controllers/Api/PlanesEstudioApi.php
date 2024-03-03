<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\PlanEstudio;

class PlanesEstudioApi extends Controller
{
    public function PlanesEstudio()
    {
        $data = PlanEstudio::get()->map(function($plan_estudio){
            return [
                'id' => $plan_estudio->id,
                'mapa_curricular_clave_mapa_curricular' => $plan_estudio->mapaCurricular->clave_mapa_curricular
            ];
        });

        return response()->json($data);
    }
}
