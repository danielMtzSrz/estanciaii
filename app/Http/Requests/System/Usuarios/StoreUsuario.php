<?php

namespace App\Http\Requests\System\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuario extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => 'required | string | max:255',
            'email' => 'required | string | email | max:255 | unique:users',
            'password' => 'required | min:8 | string'
        ];
    }
}
