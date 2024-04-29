<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;

use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $generos = config('staticdata.informacion_personal.generos');
        $tipos_sangre = config('staticdata.informacion_personal.tipos_sangre');
        $estados_civiles = config('staticdata.informacion_personal.estados_civiles');

        $users = User::all();

        return Inertia::render('System/Usuario/Index', compact('users', 'generos', 'tipos_sangre', 'estados_civiles'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated_data = $request->validate([
            'colonia_id' => '',
            'tipo_sangre_id' => '',
            'estado_civil_id' => '',
            'generos_id' => '',
            'nacionalidad_id' => '',
            
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required',
            'curp' => 'required',
            'rfc' => '',
            'nss' => 'required',
            'telefono_local' => 'required',
            'telefono_celular' => 'required',
            'name' => 'required',
            'email' => 'required',
            
            'calle' => '',
            'numero_exterior' => '',
            'numero_interior' => '',
            'profile_photo_path' => '',
        ]);

        $user = User::create([
            'tipo_sangre_id' => $input['tipo_sangre_id'],
            'estado_civil_id' => $input['estado_civil_id'],
            'generos_id' => $input['generos_id'],
            'nacionalidad_id' => $input['nacionalidad_id'],
            
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
            'numero_interior' => $input['numero_interior'],
            'password' => Hash::make('Temp123')
        ]);

        // Cargar imagen
        if($request->file('profile_photo_path')){
            $user->profile_photo_path = $request->file('profile_photo_path')->store('profile_photo_path', 'public');
            $user->save();
        }

        $user->roles()->sync($request->roles);

        return back()->with(config('messages.mensaje_exito'));
        
    }

    public function update(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'colonia_id' => '',
            'tipo_sangre_id' => '',
            'estado_civil_id' => '',
            'generos_id' => '',
            'nacionalidad_id' => '',
            
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required',
            'curp' => 'required',
            'rfc' => '',
            'nss' => 'required',
            'telefono_local' => 'required',
            'telefono_celular' => 'required',
            'name' => 'required',
            'email' => 'required',
            
            'calle' => '',
            'numero_exterior' => '',
            'numero_interior' => '',
            'profile_photo_path' => '',
        ]);
        
        $user->roles()->sync($request->roles);

        if($request->file('profile_photo_path')){
            \Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->update($request->all());

        if($request->file('profile_photo_path')) {
            $user->profile_photo_path = $request->file('profile_photo_path')->store('profile_photo_path', 'public');
            $user->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
