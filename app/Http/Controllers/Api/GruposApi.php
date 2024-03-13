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
}
