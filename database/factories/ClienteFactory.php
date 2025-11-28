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
    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'area' => $this->faker->randomElement(['Marketing', 'Ventas', 'IT', 'Recursos Humanos']),
            'dependencia' => $this->faker->company,
            'origen' => $this->faker->country,
            'email' => $this->faker->unique()->safeEmail,
            'celular' => $this->faker->phoneNumber,
            'equipo_trabajo' => json_encode([$this->faker->name, $this->faker->name]),
        ];
    }
}