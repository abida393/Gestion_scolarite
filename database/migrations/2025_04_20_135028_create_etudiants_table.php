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
            $table->unsignedBigInteger('centre_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('groupe_id');
            $table->foreign('centre_id')->references('id')->on('centres');
            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('formation_id')->references('id')->on('formations');
            $table->foreign('groupe_id')->references('id')->on('groupes');
            $table->string('etudiant_matricule');
            $table->string('etudiant_numero_dossier');
            $table->string('etudiant_serie_bac');
            $table->string('etudiant_cne');
            $table->string('etudiant_session_bac');
            $table->string('etudiant_mention_bac');
            $table->string('etudiant_nom');
            $table->string('etudiant_prenom');
            $table->date('etudiant_date_naissance');
            $table->string('etudiant_lieu_naissance');
            $table->string('etudiant_sexe');
            $table->string('etudiant_nationalite');
            $table->string('PHOTOS');
            $table->string('etudiant_adresse_postal');
            $table->string('etudiant_code_postal');
            $table->boolean('DOSSIERCOMPLET');
            $table->string('ville');
            $table->integer('etudiant_tel');
            $table->string('etudiant_email');
            $table->string('etudiant_email1');
            $table->string('nom_pere');
            $table->string('prenom_pere');
            $table->string('fonction_pere');
            $table->integer('telephone_pere');
            $table->string('cnss');
            $table->string('nom_mere');
            $table->string('prenom_mere');
            $table->string('fonction_mere');
            $table->integer('telephone_mere');
            $table->tinyInteger('droit_justification');
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
