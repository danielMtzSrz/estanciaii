<?php

namespace App\Http\Requests\Calendarizaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'aula_id' => 'required',
            'dia_semana_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ];
    }
}
