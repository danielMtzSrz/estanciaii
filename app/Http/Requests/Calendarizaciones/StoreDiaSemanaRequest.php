<?php

namespace App\Http\Requests\Calendarizaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiaSemanaRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'nombre' => 'required'
        ];
    }
}
