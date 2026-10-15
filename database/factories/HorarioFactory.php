<?php

namespace Database\Factories;

use App\Models\Horario;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Horario>
 */
class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->numberBetween(7, 19);

        return [
            'materia_id' => Materia::factory(),
            'dia' => fake()->numberBetween(1, 5),
            'hora_inicio' => sprintf('%02d:00', $horaInicio),
            'hora_fin' => sprintf('%02d:00', $horaInicio + 2),
        ];
    }
}
