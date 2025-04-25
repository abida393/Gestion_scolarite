<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $type = $this->faker->unique()->randomElement(['admin','etudiant']);

        return [
            'type_profile' => $type,
            'identifiant' => strtoupper(Str::random(8)), // e.g., 'A1B2C3D4'
            'email_ecole' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // or use Hash::make() if you prefer
        ];
    }
}
