<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('metodos_pago')->insert([
            [
                'nombre' => 'Efectivo',
                'codigo' => 'efectivo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Débito',
                'codigo' => 'debito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Crédito',
                'codigo' => 'credito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Transferencia',
                'codigo' => 'transferencia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
