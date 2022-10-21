<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Error;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index(Request $request){

        session(['breadcrumbItems' => [
            [
                'label' => 'Usuarios',
                'url' => route('user.index'),

            ]
        ]]);

        $userData = User::all();
        $roles = Role::all();
        $model_has_roles = DB::table('model_has_roles')->get();

        return Inertia::render('System/Usuario/Index', compact('userData', 'roles', 'model_has_roles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $usr = User::where('email', $request->email)->get();
            if (count($usr)) {
                return redirect()->route('user.index')->with(
                    [
                        'summary' => 'Error',
                        'severity' => 'error',
                        'detail' => 'La dirección de correo electrónico ya está registrada',
                        'life' => 5000
                    ]
                );
            }

            $user = User::create($request->all());

            $user->roles()->sync($request->roles);

            return redirect()->route('user.index')->with(
                [
                    'summary' => 'Creado correctamente',
                    'severity' => 'success',
                    'detail' => 'El usuario ha sido creado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(User $user){
        //
    }

    public function update(Request $request, User $user)
    {
        try {
            
            $user->roles()->sync($request->roles);

            $user->update($request->all());

            return redirect()->route('user.index')->with(
                [
                    'summary' => 'Creado correctamente',
                    'severity' => 'success',
                    'detail' => 'El usuario ha sido modificado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function destroy(Request $request, User $user)
    {
        try {
            $user->delete();

            return redirect()->route('user.index')->with(
                [
                    'summary' => 'Eliminado correctamente',
                    'severity' => 'error',
                    'detail' => 'El usuario ha sido eliminado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }
}
