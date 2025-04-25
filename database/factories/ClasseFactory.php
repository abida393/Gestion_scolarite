<?php

namespace Database\Factories;

use App\Models\filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
class ClasseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filieres_id' => filiere::factory(), // creates & links a filière
            'nom_classe' => $this->faker->bothify('Classe ###'), // e.g., "Classe 101"
        ];
    }
}
