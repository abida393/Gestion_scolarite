<?php

namespace Database\Factories;

use App\Models\formation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Responsable>
 */
class ResponsableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_profile' => 'responsable',
            'formation_id' => formation::factory(),
            'email_ecole' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'identifiant' => strtoupper($this->faker->bothify('??######')),
            'respo_nom' => $this->faker->lastName,
            'respo_prenom' => $this->faker->firstName,
            'respo_sex' => $this->faker->randomElement(['Homme', 'Femme']),
            'respo_nationalite' => $this->faker->country,
            'respo_cin' => strtoupper($this->faker->bothify('??######')),
            'respo_cnss' => $this->faker->numerify('########'),
            'respo_diplomes' => $this->faker->randomElement(['Licence', 'Master', 'Doctorat']),
            'respo_date_naissance' => $this->faker->date('Y-m-d', '-30 years'),
            'respo_lieu_naissance' => $this->faker->city,
            'respo_tel' => $this->faker->phoneNumber,
            'respo_adresse' => $this->faker->address,
            'respo_email' => $this->faker->unique()->safeEmail,
            'respo_contrat' => $this->faker->randomElement(['CDD', 'CDI']),
            'respo_date_embauche' => $this->faker->date(),
            'respo_type_paiement' => $this->faker->randomElement(['Espèces', 'Virement']),
            'respo_banque' => $this->faker->company . ' Bank',
            'respo_rib' => $this->faker->iban('MA'),
            'respo_salaire' => $this->faker->randomFloat(2, 4000, 10000),
        ];
    }
}
