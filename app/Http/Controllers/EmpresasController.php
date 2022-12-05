<?php

namespace App\Http\Controllers;

use App\Models\Domicilios\Domicilio;
use App\Models\Empresas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render(
            "Empresas/Index",
            [
                'empresas' => Empresas::with(['domicilio.colonia.municipio.estado'])->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'razon_social' => 'required|string',
            'rfc' => 'required|string',
            'colonia' => 'required|int',
            'calle' => 'required',
            'numero_exterior' => 'int',
            'numero_interior' => 'int',

        ]);
        $domicilio = Domicilio::create([
            'colonia_id' => $data['colonia'],
            'calle' => $data['calle'],
            'numero_exterior' => $data['numero_exterior'],
            'numero_interior' => $data['numero_interior'],
        ]);
        // Crear empresa
        $empresa = Empresas::create([
            'nombre_empresa' => $data['nombre'],
            'razon_social' => $data['razon_social'],
            'rfc' => $data['rfc'],
            'domicilio_id' => $domicilio->id,

        ]);
        return back()->with(
            [
                'backgroundNotification' => 'success',
                'titleNotification' => '¡Exito!',
                'messageNotification' => 'Se ha creado correctamente',
                'lifeNotification' => 5000,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresas  $empresas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresas $empresa)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'razon_social' => 'required|string',
            'rfc' => 'required|string',
            'colonia' => 'required|int',
            'calle' => 'required',
            'numero_exterior' => 'int',
            'numero_interior' => 'int',

        ]);
        $domicilio = Domicilio::findOrFail($empresa->domicilio->id);
        $domicilio->colonia_id = $data['colonia'];
        $domicilio->calle = $data['calle'];
        $domicilio->numero_exterior = $data['numero_exterior'];
        $domicilio->numero_interior = $data['numero_interior'];
        $domicilio->save();

        // Crear empresa
        $empresa->nombre_empresa = $data['nombre'];
        $empresa->razon_social = $data['razon_social'];
        $empresa->rfc = $data['rfc'];
        $empresa->domicilio_id = $domicilio->id;
        $empresa->save();

        return back()->with(
            [
                'backgroundNotification' => 'success',
                'titleNotification' => '¡Exito!',
                'messageNotification' => 'Se ha actualizado correctamente',
                'lifeNotification' => 5000,
            ]
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresas  $empresas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresas $empresas)
    {
        //
    }
}
