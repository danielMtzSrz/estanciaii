<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\Materia;

class MateriasApi extends Controller
{
    public function Materias()
    {
        $data = Materia::get();

        return response()->json($data);
    }
}
