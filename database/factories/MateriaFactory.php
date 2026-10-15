<?php

namespace Database\Factories;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Materia>
 */
class MateriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement([
                'Cálculo Diferencial',
                'Álgebra Lineal',
                'Programación Web',
                'Bases de Datos',
                'Estructuras de Datos',
                'Sistemas Operativos',
                'Redes de Computadoras',
                'Ingeniería de Software',
                'Física General',
                'Probabilidad y Estadística',
            ]),
            'creditos' => fake()->numberBetween(1, 10),
            'profesor' => fake()->name(),
        ];
    }
}
