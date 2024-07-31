<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Domicilios\{Pais, Estado, Municipio, Colonia};


class Domicilios extends Controller
{
    public function Paises()
    {
        $paises = Pais::orderBy('nombre', 'asc')->get();

        return response()->json($paises);
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

    public function ObtenerColonia($id_colonia)
    {
        $colonia = Colonia::with('municipio.estado.pais')->where("id", $id_colonia)->orderBy('nombre', 'asc')->get();

        return response()->json($colonia);
    }

    public function cp($cp)
    {

        $colonias = Colonia::where('cp','like',"{$cp}%")
            ->with(['municipio' => ['estado']])
            ->get();

        return response()->json($colonias);
    }
}
