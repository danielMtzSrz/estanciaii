<?php

namespace App\Http\Requests\Calendarizaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodoRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'tipo_periodo_id' => 'required',
            'titulo' => 'required | string | max:255',
            'descripcion' => 'required | string |',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'periodo_activo' => 'numeric'
        ];
    }
}
