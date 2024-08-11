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

        $data_permisos = Permission::orderBy('description', 'asc')->get();

        return Inertia::render('System/RolesModulo/Index', compact('roles', 'data_permisos'));
    }

    public function store(StoreRoles $request)
    {

        $role = Role::create($request->validated());

        $role->permissions()->sync($request->permissions);

        return back()->with(config('messages.mensaje_exito'));
    }

    public function edit(Role $role)
    {
        $permisos = Permission::orderBy('description', 'desc')->get();
        $role_has_permission = DB::table('role_has_permissions')->where('role_id', $role->id)->select('permission_id')->get();

        return Inertia::render('System/RolesModulo/Update', compact('role', 'permisos', 'role_has_permission'));
    }

    public function update(UpdateRoles $request, Role $role)
    {
        $role->update($request->validated());

        $role->permissions()->sync($request->permissions);

        return back()->with(config('messages.mensaje_actualizar'));        
    }


    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
