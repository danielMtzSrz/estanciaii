<?php

namespace App\Http\Requests\EstructuraAcademica;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAulaReservacionRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aula_id' => 'required | numeric',
            'solicitante_id' => 'required | numeric',
            'horario_inicio' => 'required',
            'horario_final' => 'required',
            'asunto' => 'required | string | max:75',
            'descripcion' => 'required | string | max:255'
        ];
    }
}
