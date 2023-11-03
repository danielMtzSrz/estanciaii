<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Http\Requests\System\Empresas\StoreEmpresasRequest;

use App\Models\Domicilios\Pais;

use Illuminate\Http\Request;

use Inertia\Inertia;

class PaisesController extends Controller
{
    public function index()
    {
        $paises = Pais::get();

        return Inertia::render("System/Paises/Index", compact('paises'));
    }

    public function store(Request $request)
    {
        $pais = Pais::create($request->all());

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $pais = Pais::find($id);

        $pais->update($request->all());

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);

        $pais->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
