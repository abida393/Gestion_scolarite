<?php

namespace Database\Factories;

use App\Models\classe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classe_id' => classe::factory(), // creates and associates with a new Classe
            'nom_module' => $this->faker->words(2, true), // e.g., "Mathématiques Appliquées"
            'status' => $this->faker->boolean(80), // 80% chance of true
            'nbr_matiere' => $this->faker->numberBetween(1, 6),
            'note_general' => $this->faker->randomFloat(2, 0, 20), // e.g., 14.25
        ];
    }
}
