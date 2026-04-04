<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Coca-Cola',
            'Pepsi',
            'Arcor',
            'La Serenísima',
            'Sancor',
            'Molinos',
            'Lucchetti',
            'Gallo',
            'Terrabusi',
            'Bagley',
            'Quilmes',
            'Brahma',
            'Manaos',
            'Ser',
            'Ilolay',
            'La Paulina',
            'Natura',
            'Hellmann\'s',
            'Knorr',
            'Maggi'
        ];

        foreach ($marcas as $marca) {
            Marca::updateOrCreate(
                ['nombre' => $marca],
                ['activo' => true] // sacalo si no tenés este campo
            );
        }
    }
}
