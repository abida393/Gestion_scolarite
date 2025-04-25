<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enseignant_nom' => $this->faker->lastName,
            'enseignant_prenom' => $this->faker->firstName,
            'enseignant_sexe' => $this->faker->randomElement(['Homme', 'Femme']),
            'enseignant_nationalite' => $this->faker->country,
            'enseignant_cin' => strtoupper($this->faker->bothify('??######')),
            'enseignant_cnss' => $this->faker->numerify('########'),
            'enseignant_diplomes' => $this->faker->randomElement(['Licence', 'Master', 'Doctorat']),
            'enseignant_specialite' => $this->faker->word,
            'enseignant_date_naissance' => $this->faker->date('Y-m-d', '-25 years'),
            'enseignant_lieu_naissance' => $this->faker->city,
            'enseignant_tel' => $this->faker->phoneNumber,
            'enseignant_adresse_postale' => $this->faker->address,
            'enseignant_email' => $this->faker->unique()->safeEmail,
            'enseignant_contrat' => $this->faker->randomElement(['CDD', 'CDI']),
            'enseignant_date_embauche' => $this->faker->date(),
            'enseignant_salaire' => $this->faker->numberBetween(3000, 12000),
            'enseignant_permanent_vacataire' => $this->faker->randomElement(['Permanent', 'Vacataire']),
            'enseignant_fonction_principale' => $this->faker->jobTitle,
            'enseignant_employeur_principal' => $this->faker->company,
            'enseignant_type_paiement' => $this->faker->randomElement(['Espèces', 'Virement']),
            'enseignant_banque' => $this->faker->company . ' Bank',
            'enseignant_rib' => $this->faker->iban('MA'),
        ];
    }
}
