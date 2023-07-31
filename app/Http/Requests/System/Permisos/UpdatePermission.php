<?php

namespace App\Http\Requests\System\Permisos;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermission extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'module_name' => 'required',
            'name' => 'required | string | max:255 | unique:permissions,name,' . $this->route('permission'),
            'description' => 'required | string',
        ];
    }
}
