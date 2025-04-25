<?php

namespace Database\Factories;

use App\Models\classe;
use App\Models\filiere;
use App\Models\formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_profile' => 'etudiant', // Make sure this exists in the profiles table
            'formation_id' => formation::factory(),
            'classes_id' => classe::factory(),
            'filiere_id' => filiere::factory(),

            'etudiant_cin' => strtoupper($this->faker->bothify('??######')),
            'etudiant_serie_bac' => $this->faker->randomElement(['S', 'ES', 'L', 'ST']),
            'etudiant_cne' => strtoupper($this->faker->bothify('CNE#######')),
            'etudiant_session_bac' => $this->faker->randomElement(['2020', '2021', '2022']),
            'etudiant_mention_bac' => $this->faker->randomElement(['Passable', 'Bien', 'Très Bien']),
            'annee_obtention_bac' => $this->faker->date('Y-m-d', '-2 years'),

            'etudiant_nom' => $this->faker->lastName,
            'etudiant_prenom' => $this->faker->firstName,
            'etudiant_date_naissance' => $this->faker->date('Y-m-d', '-20 years'),
            'etudiant_lieu_naissance' => $this->faker->city,
            'etudiant_sexe' => $this->faker->randomElement(['Homme', 'Femme']),
            'etudiant_nationalite' => $this->faker->country,
            'PHOTOS' => $this->faker->imageUrl(),

            'etudiant_adresse' => $this->faker->address,
            'etudiant_code_postal' => $this->faker->postcode,
            'DOSSIERCOMPLET' => $this->faker->boolean(),
            'ville' => $this->faker->city,
            'etudiant_tel' => $this->faker->phoneNumber,
            'etudiant_email' => $this->faker->unique()->safeEmail,

            'nom_pere' => $this->faker->lastName,
            'prenom_pere' => $this->faker->firstNameMale,
            'fonction_pere' => $this->faker->jobTitle,
            'telephone_pere' => $this->faker->phoneNumber,
            'cnss' => $this->faker->numerify('########'),

            'nom_mere' => $this->faker->lastName,
            'prenom_mere' => $this->faker->firstNameFemale,
            'fonction_mere' => $this->faker->jobTitle,
            'telephone_mere' => $this->faker->phoneNumber,
        ];
    }
}
