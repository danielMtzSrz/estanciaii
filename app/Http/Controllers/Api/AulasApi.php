<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Aula;

class AulasApi extends Controller
{
    public function Aulas()
    {
        $data = Aula::orderBy('nombre', 'asc')->get();

        return response()->json($data);
    }
}
