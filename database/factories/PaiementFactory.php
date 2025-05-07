<?php

namespace Database\Factories;

use App\Models\etudiant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paiement>
 */
class PaiementFactory extends Factory
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
            'montant_total' => $this->faker->randomFloat(2, 1000, 5000),
            'montant_paye' => $this->faker->randomFloat(2, 0, 5000),
            'montant_restant' => $this->faker->randomFloat(2, 0, 5000),
            'mode_paiement' => $this->faker->randomElement(['cash', 'credit card', 'bank transfer']),
            'status' => $this->faker->randomElement(['validé', 'en_attente', 'refusé']),
            'date_paiement' => $this->faker->date(),
        ];
    }
}
