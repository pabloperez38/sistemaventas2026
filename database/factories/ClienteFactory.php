<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function consumidorFinal()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'Consumidor final',
                'email' => 'email@email.com',
                'numero_documento' => '11-22222222-3',
                'telefono' => '-',
            ];
        });
    }
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'numero_documento' => $this->faker->randomElement([
                $this->faker->numberBetween(20000000, 45000000), // DNI
                '20-' . $this->faker->numberBetween(20000000, 45000000) . '-' . $this->faker->randomDigit() // CUIT
            ]),
            'telefono' => $this->faker->phoneNumber(),
        ];
    }
}
