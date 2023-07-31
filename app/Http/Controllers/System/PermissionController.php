<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\System\Permisos\{StorePermission, UpdatePermission};

use Inertia\Inertia;

class PermissionController extends Controller
{

    public function index()
    {
        $permisos = Permission::orderBy('name', 'asc')->get();

        return Inertia::render('System/Permisos/Index', compact('permisos'));
    }

    public function store(StorePermission $request)
    {
        Permission::create($request->validated());

        return back()->with(config('messages.mensaje_exito'));   
    }

    public function update(UpdatePermission $request, $id)
    {
        $permiso = Permission::find($id);

        $permiso->update($request->validated());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $permiso = Permission::find($id);

        $permiso->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
