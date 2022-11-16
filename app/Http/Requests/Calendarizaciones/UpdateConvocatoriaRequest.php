<?php

namespace App\Http\Requests\Calendarizaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConvocatoriaRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'periodo_id' => 'required',
            'tipo_convocatoria_id' => 'required',
            'contenido' => 'required | string',
            'log_id' => '',
        ];
    }
}
