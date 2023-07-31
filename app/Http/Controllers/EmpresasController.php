<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Http\Requests\System\Empresas\StoreEmpresasRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $empresa = Empresas::create($request->validated());

        // Cargar imagen
        if($request->file('imagen')){
            $empresa->imagen = $request->file('imagen')->store('imagen', 'public');
            $empresa->save();
        }

        return back()->with(
            [
                'summary' => '¡Éxito!',
                'detail' => 'Creado correctamente',
                'severity' => 'success',
                'life' => 5000
            ]
        );
    }

    public function update(StoreEmpresasRequest $request, Empresas $empresa)
    {

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
                'summary' => '¡Éxito!',
                'detail' => 'Actualizado correctamente',
                'severity' => 'success',
                'life' => 5000
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
