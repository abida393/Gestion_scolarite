<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_stage' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'entreprise' => $this->faker->company,
            'duree' => $this->faker->numberBetween(1, 12) . ' months', // Random duration between 1 and 12 months
            'photo' => $this->faker->imageUrl(640, 480, 'business', true), // Random image URL
            'domaine' => $this->faker->word,
            'email_entreprise' => $this->faker->companyEmail,
        ];
    }
}
