<?php

namespace App\Http\Requests\EstructuraAcademica;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'carrera_id' => 'required | numeric',
            'aula_id' => 'required | numeric',
            'tutor_id' => 'required | numeric',
            'nombre' => 'required | string | max:75',
            'turno' => 'required | boolean'
        ];
    }
}
