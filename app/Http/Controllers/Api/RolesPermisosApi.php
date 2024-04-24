<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;

use Spatie\Permission\Models\Role;

class RolesPermisosApi extends Controller
{
    public function Roles()
    {
        $data = Role::orderBy('name', 'asc')->get();

        return response()->json($data);
    }

    public function UserRoles($id_user)
    {
        $user = User::where('id', $id_user)->first();
        
        $data = $user->roles->pluck('id');

        return response()->json($data);
    }
}
