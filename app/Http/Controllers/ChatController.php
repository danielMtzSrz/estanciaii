<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Chat\Conversacion;
use App\Models\Chat\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return Inertia::render('Chat/Index', compact('user'));
    }

    // api func
    public function sendMessage(Request $request)
    {
        $msg = new Mensaje();
        $msg['autor_id'] = $request->autor_id;
        $msg['conversacion_id'] = $request->id;
        $msg['mensaje'] = $request->mensaje;
        $msg->save();
        broadcast(new ChatEvent($request->id, $msg->id))->toOthers();
    }

    public function getConversacion($id)
    {
        $conversacion = Conversacion::with('mensajes')->find($id);
        return response()->json($conversacion->mensajes);
    }

    public function getMsg($id)
    {
        $msg = Mensaje::find($id);
        return response()->json($msg);
    }

    public function nuevaConversacion(Request $request)
    {
        $user = Auth::user();
        $conversacion = new Conversacion();
        $mensaje = new Mensaje([
            'autor_id' => $user->id,
            'mensaje' => $message,
            'conversacion_id' => $conversacion->id,
        ]);
        dd($mensaje);
        //
        // return Inertia::render('Chat/Index');
    }
}
