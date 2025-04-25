<?php

namespace Database\Factories;

use App\Models\enseignant;
use App\Models\module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_matiere' => $this->faker->words(2, true), // e.g., "Analyse Mathématique"
            'module_id' => module::factory(), // or link to an existing one
            'coefficient' => $this->faker->numberBetween(1, 5),
            'enseignant_id' => enseignant::factory(), // or link to existing enseignant
        ];
    }
}
