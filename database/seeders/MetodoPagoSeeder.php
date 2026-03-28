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
                'nombre' => 'Transferencia',
                'codigo' => 'transferencia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Billetera Virtual',
                'codigo' => 'billetera',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
