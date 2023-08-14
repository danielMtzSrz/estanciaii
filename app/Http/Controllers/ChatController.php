<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Chat\Conversacion;
use App\Models\Chat\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with("conversaciones.usuarios")->find(auth()->id());
        // No me jusgues tan duro hay que hacer la consulta de que se conocen por la relacion en grupo
        $contacts = User::all();
        return Inertia::render('Chat/Index', compact('user', 'contacts'));
    }

    // api func
    public function sendMessage(Request $request)
    {
        $msg = new Mensaje();
        $msg['autor_id'] = $request->autor_id;
        $msg['conversacion_id'] = $request->id;
        $msg['mensaje'] = $request->mensaje;
        $msg->save();

        //update conv
        $conv = Conversacion::find($request->id);
        $conv->updated_at = now();
        $conv->save();

        broadcast(new ChatEvent($request->id, $msg->id))->toOthers();
        return response()->noContent();
    }

    public function getConversaciones(Request $request)
    {
        $user = User::with("conversaciones.usuarios")->find($request->id);
        return response()->json($user->conversaciones);
    }

    public function getMensajes(Request $request)
    {
        $conversacion = Conversacion::with('mensajes')->find($request->id);
        return response()->json($conversacion->mensajes);
    }

    // refactor this is not efficient...
    public function getMsg($id)
    {
        $msg = Mensaje::find($id);
        return response()->json($msg);
    }

    public function createConversacion(Request $request)
    {
        // Flata agregar logica para avisarle al usuario que tiene una nueva convsresacion.
        $conversacion = Conversacion::create();
        // Crea conexion con los usuarios
        DB::table('usuario_conversacion')->insert([
            'usuario_id' => $request->autor_id,
            'conversacion_id' => $conversacion->id
        ]);
        DB::table('usuario_conversacion')->insert([
            'usuario_id' => $request->destinatario_id,
            'conversacion_id' => $conversacion->id
        ]);
        $msg = new Mensaje();
        $msg['conversacion_id'] = $conversacion->id;
        $msg['autor_id'] = $request->autor_id;
        $msg['mensaje'] = $request->mensaje;
        $msg->save();
        broadcast(new ChatEvent($conversacion->id, $msg->id))->toOthers();
        return response()->noContent();
    }
}
