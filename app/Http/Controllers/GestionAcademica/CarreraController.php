<?php

namespace App\Http\Controllers\GestionAcademica;

use App\Http\Controllers\Controller;

use App\Models\GestionAcademica\Carrera;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::orderBy('nombre', 'ASC')->get()->map(function ($carrera){
            return [
                'id' => $carrera->id,
                'nombre' => $carrera->nombre,
                'descripcion' => $carrera->descripcion,
                'estatus' => $carrera->estatus ? 'Activa' : 'Inactiva',
                'imagen' => $carrera->imagen
            ];
        });

        return Inertia::render('GestionAcademica/Carreras/Index', compact('carreras'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nombre' => 'required',
            'imagen' => 'required',
            'descripcion' => 'required',
            'estatus' => 'required'
        ]);

        $carrera = Carrera::create($request->all());

         // Cargar imagen
         if($request->file('imagen')){
            $carrera->imagen = $request->file('imagen')->store('GestionAcademica/Carreras', 'public');
            $carrera->save();
        }

        return back()->with(config('messages.mensaje_exito'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'nombre' => 'required',
            'imagen' => 'required',
            'descripcion' => 'required',
            'estatus' => 'required'
        ]);

        $carrera = Carrera::find($id);

        if($request->file('imagen')){
            Storage::disk('public')->delete($carrera->imagen);
        }

        $carrera->update($validated_data);

        if($request->file('imagen')) {
            $carrera->imagen = $request->file('imagen')->store('GestionAcademica/Carreras', 'public');
            $carrera->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function destroy($id)
    {
        $carrera = Carrera::find($id);

        Storage::disk('public')->delete($carrera->imagen);

        $carrera->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }
}
