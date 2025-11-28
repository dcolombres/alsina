<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'celular' => $this->faker->phoneNumber,
            'rol' => $this->faker->randomElement(['Developer', 'Designer', 'Project Manager', 'QA Tester']),
            'tipo' => $this->faker->randomElement(['Backend', 'Frontend', 'Fullstack', 'Mobile', 'QA']),
            'seniority' => $this->faker->randomElement(['Junior', 'Semi-Senior', 'Senior']),
            'tecnologia' => $this->faker->randomElement(['PHP', 'Laravel', 'Vue.js', 'React', 'MySQL']),
            'contrato' => $this->faker->randomElement(['CTO 1109', 'Ley Marco', 'Planta Permanente']),
            'remuneracion' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F']),
            'ur' => $this->faker->boolean,
            'extras' => $this->faker->boolean,
            'modalidad' => $this->faker->randomElement(['Remoto', 'Híbrido', 'Presencial']),
            'activo' => true,
            'dias_presencial' => $this->faker->numberBetween(0, 5),
            'dias_remoto' => $this->faker->numberBetween(0, 5),
        ];
    }
}
