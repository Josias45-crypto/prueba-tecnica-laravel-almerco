<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'identificador' => 1,
            'name' => 'Administrador',
            'nombre' => 'Administrador del Sistema',
            'email' => 'admin@grupoalmerco.com',
            'password' => Hash::make('Admin@123'),
            'cedula' => '12345678901',
            'fecha_nacimiento' => '1990-01-01',
            'numero_celular' => '987654321',
            'city_id' => 1, // Lima
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Usuario Normal de prueba
        User::create([
            'identificador' => 2,
            'name' => 'Juan Pérez',
            'nombre' => 'Juan Carlos Pérez López',
            'email' => 'juan@example.com',
            'password' => Hash::make('User@123'),
            'cedula' => '98765432101',
            'fecha_nacimiento' => '1995-05-15',
            'numero_celular' => '912345678',
            'city_id' => 1, // Lima
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}
