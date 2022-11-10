<?php

namespace App\Http\Requests\Calendarizaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTiposConvocatoriasRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'nombre' => 'required | string | max:255',
            'plantilla' => 'required |',
        ];
    }
}
