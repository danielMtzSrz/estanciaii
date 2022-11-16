<?php

namespace App\Http\Requests\GestionAcademica;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoMateriaRequest extends FormRequest
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
            'profesor_id'=>'required',
            'materia_id'=>'required',
            'horario_id'=> 'required',
            'grupo_id'=>'required',
            'periodo_id'=>'required'
        ];
    }
}
