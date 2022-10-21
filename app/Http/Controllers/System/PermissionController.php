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

        session(['breadcrumbItems' => [
            [
                'label' => 'Permisos',
                'url' => route('permission.index'),

            ]
        ]]);

        $permisos = Permission::orderBy('name', 'asc')->get();
        return Inertia::render('System/Permisos/Index', compact('permisos'));
    }

    public function create()
    {
        //
    }

    public function store(StorePermission $request)
    {
        try {
            $permiso = Permission::where('name', $request->name)->get();
            // Que esto se quite mostrando el error directamente en el modal
            if (count($permiso)) {
                return back()->with(
                    [
                        'summary' => 'Error',
                        'severity' => 'error',
                        'detail' => 'El permiso ya existe',
                        'life' => 5000
                    ]
                );
            }
            Permission::create($request->validated());

            return back()->with(
                [
                    'summary' => 'Creado correctamente',
                    'severity' => 'success',
                    'detail' => 'El permiso ha sido creado correctamente',
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

    public function edit($id)
    {
        //
    }

    public function update(UpdatePermission $request, $id)
    {

        $permiso = Permission::find($id);

        try {

            $permiso->update($request->validated());

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'El permiso ha sido modificado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function actualizar(UpdatePermission $request)
    {
        dd($request);
        $permiso = Permission::find($request->id);
        try {

            $permiso->update($request->validated());

            return back()->with(
                [
                    'summary' => '¡Éxito!',
                    'severity' => 'success',
                    'detail' => 'El permiso ha sido modificado correctamente',
                    'life' => 5000
                ]
            );
        } catch (Error $e) {
        }
    }

    public function destroy($id)
    {
        $permiso = Permission::find($id);

        $permiso->delete();

        return back()->with(
            [
                'summary' => '¡Éxito!',
                'severity' => 'success',
                'detail' => 'El permiso ha sido modificado correctamente',
                'life' => 5000
            ]
        );
    }
}
