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

    public function Estados($id_pais)
    {
        $estados = Estado::where("pais_id", $id_pais)->orderBy('nombre', 'asc')->get();

        return response()->json($estados);
    }

    public function Municipios($id_estado)
    {
        $municipios = Municipio::where("estado_id", $id_estado)->orderBy('nombre', 'asc')->get();

        return response()->json($municipios);
    }

    public function Colonias($id_municipio)
    {
        $colonias = Colonia::where("municipio_id", $id_municipio)->orderBy('nombre', 'asc')->get();

        return response()->json($colonias);
    }

    public function cp($cp)
    {

        $colonias = Colonia::where('cp','like',"{$cp}%")
            ->with(['municipio' => ['estado']])
            ->get();

        return response()->json($colonias);
    }
}
