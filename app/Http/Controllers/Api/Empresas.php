<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Empresas as EmpresasModel;


class Empresas extends Controller
{
    public function Empresas()
    {
        $data = EmpresasModel::get();

        return response()->json($data);
    }
}
