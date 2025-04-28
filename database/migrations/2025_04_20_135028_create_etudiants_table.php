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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string("type_profile");
            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('classes_id');
            $table->unsignedBigInteger('filiere_id');
            $table->foreign('type_profile')->references('type_profile')->on('profiles');
            $table->foreign('formation_id')->references('id')->on('formations');
            $table->foreign('classes_id')->references('id')->on('classes');
            $table->foreign('filiere_id')->references('id')->on('filieres');
            $table->string('email_ecole')->unique();
            $table->string('password');
            $table->string('identifiant')->unique();
            $table->string('etudiant_cin');
            $table->string('etudiant_serie_bac');
            $table->string('etudiant_cne');
            $table->string('etudiant_session_bac');
            $table->string('etudiant_mention_bac');
            $table->date('annee_obtention_bac');
            $table->string('etudiant_nom');
            $table->string('etudiant_prenom');
            $table->date('etudiant_date_naissance');
            $table->string('etudiant_lieu_naissance');
            $table->string('etudiant_sexe');
            $table->string('etudiant_nationalite');
            $table->string('PHOTOS');
            $table->string('etudiant_adresse');
            $table->string('etudiant_code_postal');
            $table->boolean('DOSSIERCOMPLET');
            $table->string('ville');
            $table->string('etudiant_tel');
            $table->string('etudiant_email');
            $table->string('nom_pere');
            $table->string('prenom_pere');
            $table->string('fonction_pere');
            $table->string('telephone_pere');
            $table->string('cnss');
            $table->string('nom_mere');
            $table->string('prenom_mere');
            $table->string('fonction_mere');
            $table->string('telephone_mere');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
