<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Logitech',
            'HP',
            'Dell',
            'Lenovo',
            'Asus',
            'Acer',
            'Samsung',
            'Kingston',
            'Corsair',
            'MSI',
            'Gigabyte',
            'Razer',
            'Redragon',
            'Intel',
            'AMD',
            'Seagate',
            'Western Digital',
            'HyperX'
        ];

        foreach ($marcas as $marca) {
            Marca::firstOrCreate([
                'nombre' => $marca
            ]);
        }
    }
}
