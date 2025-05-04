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
            'etudiant_id' => etudiant::factory(),
            'matiere_id' => matiere::factory(),
            'note' => $this->faker->randomFloat(2, 0, 20),
        ];
    }
}
