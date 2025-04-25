<?php

namespace Database\Factories;

use App\Models\annee;
use App\Models\formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\annee_formation>
 */
class Annee_formationFactory extends Factory
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
            'annee_id' => annee::factory(),
        ];
    }
}
