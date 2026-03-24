<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;
use App\Models\Marca;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $precioCompra = $this->faker->numberBetween(1000, 50000);

        return [
            'nombre' => $this->faker->words(3, true),
            'codigo' => $this->faker->unique()->ean13(),
            'imagen' => null,
            'stock' => $this->faker->numberBetween(0, 200),
            'stock_minimo' => $this->faker->numberBetween(5, 20),
            'precio_compra' => $precioCompra,
            'precio_venta' => $precioCompra * $this->faker->randomFloat(2, 1.2, 1.8),
            'activo' => $this->faker->boolean(90),
            'categoria_id' => Categoria::inRandomOrder()->first()->id,
            'marca_id' => Marca::inRandomOrder()->first()->id,
        ];
    }
}
