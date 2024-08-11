<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;

class UsuariosApi extends Controller
{
    public function Usuarios()
    {
        $data = User::get()->map(function($usuario){
            return [
                'id' => $usuario->id,
                'nombre' => $usuario->name." ".$usuario->apellido_paterno." ".$usuario->apellido_materno,
                'profile_photo_path' => $usuario->profile_photo_path,
                'horarios' => $usuario->horarios
            ];
        });

        return response()->json($data);
    }
}
