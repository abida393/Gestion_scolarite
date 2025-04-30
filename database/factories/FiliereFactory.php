<?php

namespace Database\Factories;

use App\Models\formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filiere>
 */
class FiliereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'formation_id' => formation::factory(),
            'nom_filiere' => $this->faker->words(2, true),
        ];
    }
}
