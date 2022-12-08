<?php

namespace App\Http\Requests\Modulos\ProgramacionAcademica\DireccionCarrera;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAsignaHorariosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aula_id' => 'required | numeric',
            'dia_semana_id' => 'required | numeric',
            'hora_inicio' => 'required',
            'hora_fin' => 'required'
        ];
    }
}
