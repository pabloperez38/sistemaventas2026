<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);

        User::create([
            'name' => 'Pablo Pérez',
            'email' => 'pablo.eluniversoweb@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrador');

        Configuracion::create([
            'nombre_empresa' => 'Mi Empresa',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '555-1234',
            'email' => 'info@miempresa.com',
            'logo' => '',
            'imagen_login' => '',
            'descripcion' => 'Empresa dedicada a la venta de productos de calidad.',
            'cuit' => '30-12345678-9',
            'ciudad' => 'Buenos Aires'
        ]);
    }
}
