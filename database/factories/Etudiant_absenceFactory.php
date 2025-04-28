<?php

namespace Database\Factories;

use App\Models\etudiant;
use App\Models\seance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EtudiantAbsence>
 */
class Etudiant_absenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seance_id' => seance::factory(),
            'etudiant_id' => etudiant::factory(),
            'date_justif' => $this->faker->date(),
            'date_absence' => $this->faker->date(),
            'justification' => $this->faker->sentence(),
            'justifier' => $this->faker->boolean(),
            'justification_file' => $this->faker->filePath(),
        ];
    }
}
