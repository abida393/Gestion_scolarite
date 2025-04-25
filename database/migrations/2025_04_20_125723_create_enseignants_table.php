<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('enseignant_nom');
            $table->string('enseignant_prenom');
            $table->string('enseignant_sexe');
            $table->string('enseignant_nationalite');
            $table->string('enseignant_cin');
            $table->string('enseignant_cnss');
            $table->string('enseignant_diplomes');
            $table->string('enseignant_specialite');
            $table->date('enseignant_date_naissance');
            $table->string('enseignant_lieu_naissance');
            $table->string('enseignant_tel');
            $table->string('enseignant_adresse_postale');
            $table->string('enseignant_email');
            $table->string('enseignant_contrat'); //cdd cdi 
            $table->date('enseignant_date_embauche');
            $table->string('enseignant_salaire');
            $table->string('enseignant_permanent_vacataire');
            $table->string('enseignant_fonction_principale');
            $table->string('enseignant_employeur_principal');
            $table->string('enseignant_type_paiement');
            $table->string('enseignant_banque');
            $table->string('enseignant_rib');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
