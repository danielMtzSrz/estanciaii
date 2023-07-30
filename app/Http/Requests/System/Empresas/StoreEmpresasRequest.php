<?php

namespace App\Http\Requests\System\Empresas;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresasRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'colonia_id' => 'required',
            'nombre_empresa' => 'required|string',
            'razon_social' => 'required|string',
            'rfc' => 'required|string',
            'calle' => 'required',
            'numero_exterior' => 'required|int',
            'numero_interior' => '',
            'codigo_postal' => 'required|int'
        ];
    }
}
