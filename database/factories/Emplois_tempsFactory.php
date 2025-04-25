<?php

namespace Database\Factories;

use App\Models\classe;
use App\Models\enseignant;
use App\Models\matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\emplois_temps>
 */
class Emplois_tempsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jour' => $this->faker->randomElement(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']),
            'date' => $this->faker->date(),
            'heure_debut' => $this->faker->time('H:i:s'),
            'heure_fin' => $this->faker->time('H:i:s'),
            'matiere_id' => matiere::factory(),
            'enseignant_id' => enseignant::factory(),
            'salle' => 'Salle ' . $this->faker->numberBetween(1, 10),
            'classe_id' => classe::factory(),
        ];
    }
}
