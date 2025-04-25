<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\formation>
 */
class formationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_formation' => $this->faker->words(3, true), // e.g., "Advanced Web Development"
            'prix' => $this->faker->randomFloat(2, 100, 2000), // price between 100 and 2000
        ];
    }
}
