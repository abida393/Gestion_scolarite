<?php

namespace Database\Factories;

use App\Models\etudiant;
use App\Models\matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etudiant_id' => etudiant::factory(), // Random etudiant ID linked to an Etudiant
            'matiere_id' => matiere::factory(), // Random matiere ID linked to a Matiere
            'note' => $this->faker->randomFloat(2, 0, 20), // Random grade between 0 and 20 with 2 decimal places
        ];
    }
}
