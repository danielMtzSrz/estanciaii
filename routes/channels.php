<?php

use App\Models\Chat\Conversacion;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// messenger
Broadcast::channel('private.chat.{id}', function ($user, $id) {
    // Log::debug("login_chat_id:" . $id, [$user]);
    $conversacion = Conversacion::find($id);
    $usuarios = $conversacion->usuarios;
    foreach ($usuarios as $usuario) {
        if ($usuario->id == $user->id) {
            return true;
        }
    }
    return false;
});
