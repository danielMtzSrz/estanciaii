<?php

namespace App\Http\Requests\GestionAcademica;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreraRequest extends FormRequest
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
            'nombre' => 'required | String | max:255 | unique:carreras',
            'descripcion' => 'required | String | max:255',
            'estatus' => 'required | int',
            'tipo_coordinacion_carrera' => 'required | int'
        ];
    }
}
