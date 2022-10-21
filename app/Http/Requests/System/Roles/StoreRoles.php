<?php

namespace App\Http\Requests\System\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoles extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'name' => 'required | string | max:255 | unique:roles',
        ];
    }
}
