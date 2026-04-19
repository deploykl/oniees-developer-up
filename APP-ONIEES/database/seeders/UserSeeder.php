<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; // ← AGREGAR ESTA LÍNEA

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Primero, asegurar que existe la tabla tipo_usuario con datos
        DB::table('tipo_usuario')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'ADMINISTRADOR', 'descripcion' => 'Acceso total al sistema', 'color' => 'red', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'SUPERVISOR', 'descripcion' => 'Supervisa operaciones', 'color' => 'blue', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'REGISTRADOR', 'descripcion' => 'Registra información', 'color' => 'green', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'IPRESS', 'descripcion' => 'Usuario de IPRESS', 'color' => 'purple', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'INVITADO', 'descripcion' => 'Acceso limitado', 'color' => 'gray', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Crear superusuario
        $user = User::updateOrCreate(
            ['email' => 'angel1.lasl46@gmail.com'],
            [
                'name' => 'Admin',
                'lastname' => 'Sistema',
                'password' => Hash::make('Starwar1'),
                'phone' => '999888777',
                'cargo' => 'Administrador del Sistema',
                'documento_identidad' => '76921609',
                'idtipousuario' => 1,
                'idtiporol' => 1,
                'tipo_rol' => 1,
                'state_id' => 2,
                'email_verified_at' => now(),
            ]
        );

        // Asignar rol Admin usando Spatie
        $role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user->assignRole($role);

        // Asignar todos los permisos (opcional - comentado si no hay permisos aún)
        // if (Permission::count() > 0) {
        //     $user->givePermissionTo(Permission::all());
        // }
    }
}