<?php

namespace App\Http\Requests\Seguimiento\Vacantes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacantes extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'name' => 'required | string | max:255',
            'empresa_id' => 'required',
            'contenido' => 'required | string',
            'imagen' => 'required',
        ];
    }
}
