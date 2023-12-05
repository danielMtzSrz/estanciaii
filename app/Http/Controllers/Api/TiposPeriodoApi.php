<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\TipoPeriodo;

class TiposPeriodoApi extends Controller
{
    public function TipoPeriodo()
    {
        $data = TipoPeriodo::get();

        return response()->json($data);
    }
}
