<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Vacantes\TipoAnuncio;

class TipoAnuncioApi extends Controller
{
    public function TipoAnuncio()
    {
        $data = TipoAnuncio::get();

        return response()->json($data);
    }
}
