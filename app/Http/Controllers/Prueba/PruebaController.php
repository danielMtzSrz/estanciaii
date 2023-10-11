<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\System\Prueba;
use App\Http\Requests\System\Empresas\StoreEmpresasRequest;

use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

use Carbon\Carbon;

class PruebaController extends Controller
{
    public function index()
    {
        $pruebas = Prueba::get();

        return Inertia::render("Prueba/Index", compact('pruebas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Prueba::create($request->all());
        
        return back()->with(config('messages.mensaje_exito'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prueba = Prueba::find($id);

        if(isset($prueba->imagen) && $request->file('imagen')){
            Storage::disk('public')->delete($prueba->imagen);
        }
        
        $prueba->update($request->all());
        
        if($request->file('imagen')) {
            $path = "prueba/imagenes";
            $nombreArchivo = Carbon::now()->format('Y-m-d H-m-s')." - ".$request->file('imagen')->getClientOriginalName();
            $prueba->imagen = $request->file('imagen')->storeAs($path, $nombreArchivo, 'public');
            $prueba->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
