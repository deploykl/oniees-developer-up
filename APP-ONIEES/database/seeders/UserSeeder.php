<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'Sistema',
            'email' => 'angel1.lasl46@gmail.com',
            'password' => Hash::make('Starwar1'),
            'phone' => '999888777',
            'cargo' => 'Administrador',
            'tipo_rol' => 'admin',
            'documento_identidad' => '76921609',
        ]);

        User::create([
            'name' => 'Jorge',
            'lastname' => 'Ramirez',
            'email' => 'direccion@minsa.gob.pe',
            'password' => Hash::make('password123'),
            'cargo' => 'Director',
            'tipo_rol' => 'direccion',
            'region_id' => 1,
            'nombre_region' => 'Lima',
        ]);

        User::create([
            'name' => 'Carlos',
            'lastname' => 'Mendoza',
            'email' => 'eess@minsa.gob.pe',
            'password' => Hash::make('password123'),
            'cargo' => 'Jefe de Equipamiento',
            'tipo_rol' => 'eess',
            'region_id' => 1,
            'nombre_region' => 'Lima',
            'red' => 'Red Lima Norte',
            'establecimiento' => 'Hospital Base',
        ]);
    }
}