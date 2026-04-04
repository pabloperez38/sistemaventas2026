<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;
use App\Models\Marca;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $precioCompra = $this->faker->numberBetween(100, 5000);

        // Categoría random desde DB
        $categoria = Categoria::inRandomOrder()->first();
        $marca = Marca::inRandomOrder()->first();

        $nombre = $this->generarNombreProducto($categoria->nombre, $marca->nombre);

        return [
            'nombre' => $nombre,
            'codigo' => $this->faker->unique()->ean13(),
            'imagen' => null,
            'stock' => $this->faker->numberBetween(0, 200),
            'stock_minimo' => $this->faker->numberBetween(5, 20),
            'precio_compra' => $precioCompra,
            'precio_venta' => round($precioCompra * $this->faker->randomFloat(2, 1.2, 1.8), 2),
            'activo' => $this->faker->boolean(90),
            'categoria_id' => $categoria->id,
            'marca_id' => $marca->id,
        ];
    }

    private function generarNombreProducto($categoria, $marca)
    {
        switch (strtolower($categoria)) {

            case 'bebidas':
                return $this->faker->randomElement([
                    "Gaseosa $marca Cola 500ml",
                    "Gaseosa $marca Cola 1.5L",
                    "Gaseosa $marca Naranja 500ml",
                    "Gaseosa $marca Limón 1.5L",
                    "Agua Mineral $marca 500ml",
                    "Agua Mineral $marca 1.5L",
                    "Agua Saborizada $marca Pomelo 500ml",
                    "Agua Saborizada $marca Manzana 1.5L",
                    "Jugo $marca Naranja 1L",
                    "Jugo $marca Multifruta 1L",
                    "Jugo $marca Durazno 1L",
                    "Cerveza $marca Lata 473ml",
                    "Cerveza $marca Botella 1L",
                    "Cerveza $marca Pack x6",
                    "Energizante $marca 250ml",
                    "Energizante $marca 473ml",
                    "Gaseosa $marca Zero 1.5L",
                    "Agua con Gas $marca 500ml",
                    "Tónica $marca 1L",
                    "Soda $marca 1.5L"
                ]);

            case 'lacteos':
                return $this->faker->randomElement([
                    "Leche Entera $marca 1L",
                    "Leche Descremada $marca 1L",
                    "Leche Parcial $marca 1L",
                    "Leche Sin Lactosa $marca 1L",
                    "Yogur $marca Vainilla 190g",
                    "Yogur $marca Frutilla 190g",
                    "Yogur $marca Durazno 190g",
                    "Yogur Bebible $marca 1L",
                    "Queso Cremoso $marca",
                    "Queso Port Salut $marca",
                    "Queso Rallado $marca 150g",
                    "Queso en Fetass $marca 200g",
                    "Manteca $marca 200g",
                    "Manteca $marca 100g",
                    "Crema de Leche $marca 200ml",
                    "Crema de Leche $marca 500ml",
                    "Leche Chocolatada $marca 1L",
                    "Postre Lácteo $marca Chocolate",
                    "Postre Lácteo $marca Vainilla",
                    "Flan $marca 190g"
                ]);

            case 'almacen':
                return $this->faker->randomElement([
                    "Arroz $marca Largo Fino 1kg",
                    "Arroz $marca Integral 1kg",
                    "Fideos $marca Spaghetti 500g",
                    "Fideos $marca Tirabuzón 500g",
                    "Fideos $marca Mostachol 500g",
                    "Azúcar $marca 1kg",
                    "Azúcar Rubia $marca 1kg",
                    "Harina 000 $marca 1kg",
                    "Harina 0000 $marca 1kg",
                    "Aceite Girasol $marca 900ml",
                    "Aceite Mezcla $marca 900ml",
                    "Aceite Oliva $marca 500ml",
                    "Sal Fina $marca 500g",
                    "Sal Gruesa $marca 1kg",
                    "Lentejas $marca 500g",
                    "Garbanzos $marca 500g",
                    "Puré de Tomate $marca 520g",
                    "Salsa de Tomate $marca 340g",
                    "Caldo Cubo $marca Carne",
                    "Caldo Cubo $marca Verdura"
                ]);
            case 'snacks':
                return $this->faker->randomElement([
                    "Papas Fritas $marca Clásicas 150g",
                    "Papas Fritas $marca BBQ 150g",
                    "Papas Fritas $marca Queso 150g",
                    "Galletitas Dulces $marca 200g",
                    "Galletitas Saladas $marca 200g",
                    "Galletitas Rellenas $marca Chocolate",
                    "Galletitas Rellenas $marca Vainilla",
                    "Chocolate $marca 100g",
                    "Chocolate con Almendras $marca 120g",
                    "Chocolate Blanco $marca 100g",
                    "Snack Mix $marca 120g",
                    "Maní Salado $marca 100g",
                    "Maní con Chocolate $marca 150g",
                    "Palitos Salados $marca 100g",
                    "Bizcochitos $marca 200g",
                    "Barra de Cereal $marca Frutilla",
                    "Barra de Cereal $marca Chocolate",
                    "Turrón $marca 80g",
                    "Gomitas $marca 100g",
                    "Caramelos $marca 150g"
                ]);

            default:
                return ucfirst($categoria) . " $marca";
        }
    }
}
