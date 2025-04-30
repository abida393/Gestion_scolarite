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
            'classe_id' => classe::factory(),
            'nom_module' => $this->faker->words(2, true),
            'status' => $this->faker->boolean(80),
            'nbr_matiere' => $this->faker->numberBetween(1, 6),
            'note_general' => $this->faker->randomFloat(2, 0, 20), 
        ];
    }
}
