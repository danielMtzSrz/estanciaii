<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder{

    public function run(){
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleEstudiante = Role::create(['name' => 'Estudiante']);

        // Permission::create(['name' => 'tablaperiodica.update']); -> Nos permite crear un permiso
    }
}
