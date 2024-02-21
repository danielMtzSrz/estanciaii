<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\TipoConvocatoria;

class TiposConvocatoriaApi extends Controller
{
    public function TiposConvocatoria()
    {
        $data = TipoConvocatoria::get();

        return response()->json($data);
    }
}
