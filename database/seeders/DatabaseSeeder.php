<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Producto;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\MarcaSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            CategoriaSeeder::class,
            MarcaSeeder::class,
            RoleSeeder::class
        ]);

        User::firstOrCreate([
            'name' => 'Pablo Pérez',
            'email' => 'pablo.eluniversoweb@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Super Administrador');

        User::firstOrCreate([
            'name' => 'Pablo Vendedor',
            'email' => 'pablo.vendedor@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Vendedor');

        Configuracion::firstOrCreate([
            'nombre_empresa' => 'Mi Empresa',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '555-1234',
            'email' => 'info@miempresa.com',
            'logo' => 'logos/logo.png',
            'imagen_login' => 'imagenes_login/fondo.jpg',
            'descripcion' => 'Empresa dedicada a la venta de productos de calidad.',
            'cuit' => '30-12345678-9',
            'ciudad' => 'Buenos Aires'
        ]);
        Cliente::factory()->consumidorFinal()->create();
        Cliente::factory()->count(10)->create();
        Producto::factory()->count(200)->create();
    }
}
