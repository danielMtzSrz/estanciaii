<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Http\Requests\System\Empresas\StoreEmpresasRequest;
use Illuminate\Http\Request;

use Inertia\Inertia;

class EmpresasController extends Controller
{
    public function index()
    {
        $empresas = Empresas::toIndex()->get()->map(function($empresa){
            return $empresa->indexMap();
        });

        return Inertia::render("System/Empresas/Index", compact('empresas'));
    }

    public function store(StoreEmpresasRequest $request)
    {
        // Crear empresa
        $empresa = Empresas::create([
            'colonia_id'      => $data['colonia_id'],
            'nombre_empresa'  => $data['nombre_empresa'],
            'razon_social'    => $data['razon_social'],
            'rfc'             => $data['rfc'],
            'calle'           => $data['calle'],
            'numero_exterior' => $data['numero_exterior'],
            'numero_interior' => $data['numero_interior'],
            'codigo_postal'   => $data['codigo_postal']
        ]);

        // Cargar imagen
        if($request->file('imagen')){
            $empresa->imagen = $request->file('imagen')->store('imagen', 'public');
            $empresa->save();
        }

        return back()->with(
            [
                'backgroundNotification' => 'success',
                'titleNotification' => '¡Exito!',
                'messageNotification' => 'Creado correctamente',
                'lifeNotification' => 5000,
            ]
        );
    }

    public function update(StoreEmpresasRequest $request, Empresas $empresa)
    {

        dd($request->all());

        if($request->file('imagen')){
            Storage::disk('public')->delete($empresa->imagen);
        }

        $empresa->update($request->validated());

        if($request->file('imagen')) {
            $empresa->imagen = $request->file('imagen')->store('imagen', 'public');
            $empresa->save();
        }

        return back()->with(
            [
                'backgroundNotification' => 'success',
                'titleNotification' => '¡Exito!',
                'messageNotification' => 'Actualizado correctamente',
                'lifeNotification' => 5000,
            ]
        );
    }

    public function destroy(Empresas $empresa)
    {
        Storage::disk('public')->delete($empresa->imagen);

        $empresa->delete();

        return back()->with(
            [
                'summary' => '¡Éxito!',
                'severity' => 'success',
                'detail' => 'Eliminado correctamente',
                'life' => 5000
            ]
        );
    }
}
