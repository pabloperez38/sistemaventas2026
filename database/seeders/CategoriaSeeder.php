<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Computadoras',
            'Laptops',
            'Monitores',
            'Teclados',
            'Mouse',
            'Impresoras',
            'Almacenamiento',
            'Memorias RAM',
            'Placas de Video',
            'Procesadores',
            'Motherboards',
            'Fuentes de Poder',
            'Gabinetes',
            'Auriculares',
            'Parlantes'
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate([
                'nombre' => $categoria
            ]);
        }
    }
}
