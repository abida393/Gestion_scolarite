<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\annee;
use App\Models\annee_formation;
use App\Models\classe;
use App\Models\demandes_documents;
use App\Models\document;
use App\Models\emplois_temps;
use App\Models\enseignant;
use App\Models\etudiant;
use App\Models\etudiant_absence;
use App\Models\evenement;
use App\Models\examen;
use App\Models\filiere;
use App\Models\formation;
use App\Models\matiere;
use App\Models\module;
use App\Models\news;
use App\Models\note;
use App\Models\paiement;
use App\Models\periode;
use App\Models\profile;
use App\Models\responsable;
use App\Models\seance;
use App\Models\stage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    $this->call(ReponsesTableSeeder::class);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        formation::factory()->create([
            'id' => 1,
            'nom_formation' => 'Informatique',
            'prix' => 1000,
        ]);

        filiere::factory(10)->create();
        annee::factory(10)->create();
        classe::factory(10)->create();
        module::factory(10)->create();
        profile::factory(2)->create();
        enseignant::factory()->count(10)->create();
        matiere::factory(10)->create();
        examen::factory(10)->create();
        responsable::factory(10)->create();
        etudiant::factory(10)->create();
        seance::factory(10)->create();
        etudiant_absence::factory(10)->create();
        annee_formation::factory(10)->create();
        document::factory(10)->create();
        // demandes_documents::factory(10)->create();
        periode::factory(10)->create();
        emplois_temps::factory(10)->create();
        stage::factory(10)->create();
        news::factory(10)->create();
        evenement::factory(10)->create();
        paiement::factory(10)->create();
        note::factory(10)->create();
    }
}
