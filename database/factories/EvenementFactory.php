<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence, // Random title for the event
            'date' => $this->faker->date(), // Random date for the event
            'heure_debut' => $this->faker->time('H:i:s'), // Random start time
            'heure_fin' => $this->faker->time('H:i:s'), // Random end time
        ];
    }
}
