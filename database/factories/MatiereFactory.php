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
            'nom_matiere' => $this->faker->words(2, true),
            'module_id' => module::factory(),
            'coefficient' => $this->faker->numberBetween(1, 5),
            'enseignant_id' => enseignant::factory(),
        ];
    }
}
