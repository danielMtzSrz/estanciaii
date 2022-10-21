<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::create(
            [
                'name' => "Juan Pablo Marcial",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678')
            ]
        );

        $this->call(RoleSeeder::class); // Nos permite llamar el seeder que creamos y ejecutarlo

    }
}
