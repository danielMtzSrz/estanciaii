<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Calendarizaciones\Periodo;

class PeriodosApi extends Controller
{
    public function Periodos()
    {
        $data = Periodo::get();

        return response()->json($data);
    }
}
