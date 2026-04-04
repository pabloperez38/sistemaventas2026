<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Bebidas',
            'Lácteos',
            'Almacén',
            'Snacks',
            'Congelados',
            'Limpieza',
            'Higiene',
            'Panadería',
            'Carnicería',
            'Verdulería',
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate([
                'nombre' => $categoria,
                'activo' => true // sacalo si no tenés este campo
            ]);
        }
    }
}
