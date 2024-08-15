<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;

use Inertia\Inertia;

use Carbon\Carbon;

use PDF;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $generos = config('staticdata.informacion_personal.generos');
        $tipos_sangre = config('staticdata.informacion_personal.tipos_sangre');
        $estados_civiles = config('staticdata.informacion_personal.estados_civiles');

        $users = User::all();

        return Inertia::render('System/Usuario/Index', compact('users', 'generos', 'tipos_sangre', 'estados_civiles'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated_data = $request->validate([
            'colonia_id' => '',
            'tipo_sangre_id' => '',
            'estado_civil_id' => '',
            'generos_id' => '',
            'nacionalidad_id' => '',
            
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required',
            'curp' => 'required',
            'rfc' => '',
            'nss' => 'required',
            'telefono_local' => 'required',
            'telefono_celular' => 'required',
            'name' => 'required',
            'email' => 'required',
            
            'calle' => '',
            'numero_exterior' => '',
            'numero_interior' => '',
            'profile_photo_path' => '',

            'horarios' => ''
        ]);

        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);
        $validated_data['password'] = Hash::make('Temp123');

        $user = User::create($validated_data);

        // Cargar imagen
        if($request->file('profile_photo_path')){
            $user->profile_photo_path = $request->file('profile_photo_path')->store('profile_photo_path', 'public');
            $user->save();
        }

        $user->roles()->sync($request->roles);

        return back()->with(config('messages.mensaje_exito'));
        
    }

    public function update(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'colonia_id' => '',
            'tipo_sangre_id' => '',
            'estado_civil_id' => '',
            'generos_id' => '',
            'nacionalidad_id' => '',
            
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required',
            'curp' => 'required',
            'rfc' => '',
            'nss' => 'required',
            'telefono_local' => 'required',
            'telefono_celular' => 'required',
            'name' => 'required',
            'email' => 'required',
            
            'calle' => '',
            'numero_exterior' => '',
            'numero_interior' => '',
            'profile_photo_path' => '',

            'horarios' => ''
        ]);
        
        $validated_data['horarios'] = $this->horariosMap($validated_data['horarios']);

        $user->roles()->sync($request->roles);

        if($request->file('profile_photo_path')){
            \Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->update($validated_data);

        if($request->file('profile_photo_path')) {
            $user->profile_photo_path = $request->file('profile_photo_path')->store('profile_photo_path', 'public');
            $user->save();
        }

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function updateCv(Request $request, $id_user)
    {
        $user = User::find($id_user);

        $input = $request->all();

        $user->update([
            'cv' => $input['cv']
        ]);

        return back()->with(config('messages.mensaje_actualizar'));
    }

    public function generarCv($id_user)
    {
        $fecha_actual = Carbon::now()->toDateTimeString();

        $user = User::find($id_user);

        $user_map = [
            'nombre_completo' => $user->name." ".$user->apellido_paterno." ".$user->apellido_materno,
            'telefono' => $user->telefono_celular,
            'cv' => json_decode($user->cv, true)
        ];

        // dd($user_map);

        $pdf = PDF::loadView('pdf.cv', compact('user_map', 'fecha_actual'));

        return $pdf->download('CV-'.$user_map['nombre_completo'].'.pdf');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return back()->with(config('messages.mensaje_eliminar'));
    }

    public function horariosMap($horarios)
    {
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $horarios_mapeados = [];

        foreach($dias as $dia){
            if(isset($horarios[$dia]) && $horarios[$dia]){
                $horarios_mapeados[$dia] = true;
                $horarios_mapeados[$dia.'_hora_inicio'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_inicio'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_inicio'];
                $horarios_mapeados[$dia.'_hora_fin'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_fin'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_fin'];
            }
        }
        
        return $horarios_mapeados;
    }
}
