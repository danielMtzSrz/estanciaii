<?php

namespace App\Http\Requests\EstructuraAcademica;

use Illuminate\Foundation\Http\FormRequest;

class StoreEdificioRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required | string | max:75',
        ];
    }
}
