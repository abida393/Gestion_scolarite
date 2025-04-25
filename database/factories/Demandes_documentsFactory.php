<?php

namespace Database\Factories;

use App\Models\document;
use App\Models\etudiant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\demandes_documents>
 */
class Demandes_documentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_etudiant' => etudiant::factory(),
            'id_document' => document::factory(),
            'etat_demande' => $this->faker->randomElement(['en attente', 'approuvée', 'refusée']),
        ];
    }
}
