<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

use Carbon\Carbon;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'colonia_id' => [''],
            'tipo_sangre_id' => [''],
            'estado_civil_id' => [''],
            'generos_id' => [''],
            'apellido_paterno' => [''],
            'apellido_materno' => [''],
            'fecha_nacimiento' => [''],
            'curp' => [''],
            'rfc' => [''],
            'nss' => [''],
            'telefono_local' => [''],
            'telefono_celular' => [''],
            'name' => [''],
            'email' => [''],
            'calle' => [''],
            'numero_exterior' => [''],
            'numero_interior' => ['']
        ])->validateWithBag('updateProfileInformation');

        if(isset($input['photo'])){
            $user->updateProfilePhoto($input['photo']);
        }

        if($input['email'] !== $user->email && $user instanceof MustVerifyEmail){
            $this->updateVerifiedUser($user, $input);
        }else{
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'tipo_sangre_id' => (int) $input['tipo_sangre_id'],
                'estado_civil_id' => $input['estado_civil_id'],
                'generos_id' => $input['generos_id'],
                'colonia_id' => (int) $input['colonia_id'],
                'apellido_paterno' => $input['apellido_paterno'],
                'apellido_materno' => $input['apellido_materno'],
                'fecha_nacimiento' => $input['fecha_nacimiento'],
                'curp' => $input['curp'],
                'rfc' => $input['rfc'],
                'nss' => $input['nss'],
                'telefono_local' => $input['telefono_local'],
                'telefono_celular' => $input['telefono_celular'],
                'name' => $input['name'],
                'email' => $input['email'],
                'calle' => $input['calle'],
                'numero_exterior' => $input['numero_exterior'],
                'numero_interior' => $input['numero_interior']
            ])->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'tipo_sangre_id' => (int) $input['tipo_sangre_id'],
            'estado_civil_id' => $input['estado_civil_id'],
            'generos_id' => $input['generos_id'],
            'apellido_paterno' => $input['apellido_paterno'],
            'apellido_materno' => $input['apellido_materno'],
            'fecha_nacimiento' => $input['fecha_nacimiento'],
            'curp' => $input['curp'],
            'rfc' => $input['rfc'],
            'nss' => $input['nss'],
            'telefono_local' => $input['telefono_local'],
            'telefono_celular' => $input['telefono_celular'],
            'name' => $input['name'],
            'email' => $input['email'],
            'calle' => $input['calle'],
            'numero_exterior' => $input['numero_exterior'],
            'numero_interior' => $input['numero_interior']
        ])->save();

        $user->sendEmailVerificationNotification();

        return back()->with(config('messages.mensaje_actualizar'));
    }
}
