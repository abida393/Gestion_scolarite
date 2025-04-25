<?php

namespace Database\Factories;

use App\Models\module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periode>
 */
class PeriodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id' => module::factory(),
            'nom_periode' => $this->faker->randomElement(['semestre 1', 'semestre 2', 'trimestre 1', 'trimestre 2']),
        ];
    }
}
