<?php

namespace App\Http\Requests\GestionAcademica;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapaCurricularRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'clave_mapa_curricular'=> 'required | string | max:255 | unique:mapascurriculares',
            'total_cuatrimestres' => 'required | int ',
            'total_horas' => 'required| int',
            'total_creditos'=>'required| int',
            'total_materias'=> 'required | int',
            'duracion' => 'required | int',
            'vigencia' => 'required | int',
        ];
    }
}
