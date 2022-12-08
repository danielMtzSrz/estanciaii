<?php

namespace App\Http\Requests\EstructuraAcademica;

use Illuminate\Foundation\Http\FormRequest;

class StoreAulaRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'edificio_id' => 'required | numeric',
            'tipo_aula_id' => 'required | numeric',
            'nombre' => 'required | max:50',
            'estatus' => 'required | numeric',
            'capacidad' => 'required | numeric'
        ];
    }
}
