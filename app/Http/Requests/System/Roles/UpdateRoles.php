<?php

namespace App\Http\Requests\System\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoles extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'name' => 'required | string | max:255 | unique:roles,name,'.$this->route('role')->id,
        ];
    }
}
