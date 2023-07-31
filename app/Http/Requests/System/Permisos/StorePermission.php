<?php

namespace App\Http\Requests\System\Permisos;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'name' => 'required | string | max:255 | unique:permissions',
            'module_name' => 'required',
            'description' => 'required | string',
        ];
    }
}
