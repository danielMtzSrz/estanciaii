<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Requests\System\Roles\{StoreRoles, UpdateRoles};

class RoleController extends Controller
{

    public function index()
    {
        
        $roles = Role::orderBy('name', 'asc')
            ->get()
            ->map(function($role){
                $role_array = $role->toArray();
                $role_array['permisos'] = $role->permissions;
                
                return collect($role_array);
            });
        
        // dd($roles);

        $data_permisos = Permission::orderBy('description', 'asc')->get();
        $role_has_permission = DB::table('role_has_permissions')->get();

        return Inertia::render('System/RolesModulo/Index', compact('roles', 'data_permisos', 'role_has_permission'));
    }

    public function store(StoreRoles $request)
    {

        try {

            $rol = Role::where('name', $request->name)->get();

            if (count($rol)) {
                return back()->with(
                    [
                        'summary' => 'Error',
                        'severity' => 'error',
                        'detail' => 'El rol ya existe',
                        'life' => 5000
                    ]
                );
            }

            $role = Role::create($request->validated());

            $role->permissions()->sync($request->permissions);

            return back()->with(
                [
                    'summary' => 'Creado correctamente',
                    'severity' => 'success',
                    'detail' => 'El rol ha sido creado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
        return Inertia::render('System/Roles/Index', compact('roles'));
    }

    public function show($id)
    {
        //
    }


    public function edit(Role $role)
    {

        $permisos = Permission::orderBy('description', 'desc')->get();
        $role_has_permission = DB::table('role_has_permissions')->where('role_id', $role->id)->select('permission_id')->get();

        return Inertia::render('System/RolesModulo/Update', compact('role', 'permisos', 'role_has_permission'));
    }

    public function update(UpdateRoles $request, Role $role)
    {
        try {

            $role->update($request->validated());

            $role->permissions()->sync($request->permissions);

            return back()->with(
                [
                    'summary' => 'Modificado correctamente',
                    'severity' => 'success',
                    'detail' => 'El rol ha sido modificado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
            dd($e);
        }
    }


    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return back()->with(
                [
                    'summary' => 'Eliminado correctamente',
                    'severity' => 'success',
                    'detail' => 'El rol ha sido eliminado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }
}
