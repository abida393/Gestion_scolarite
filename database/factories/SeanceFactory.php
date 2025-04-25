<?php

namespace Database\Factories;

use App\Models\matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seance>
 */
class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('8:00', '16:00');
        $end = (clone $start)->modify('+2 hours');

        return [
            'matiere_id' => matiere::factory(),
            'date_seance' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'heure_debut' => $start->format('H:i:s'),
            'heure_fin' => $end->format('H:i:s'),
            'salle' => 'Salle ' . $this->faker->numberBetween(1, 20),
        ];
    }
}
