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
        Schema::create('demandes_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_etudiant");
            $table->foreign("id_etudiant")->references('id')->on('etudiants');
            $table->unsignedBigInteger("nom_document");
            $table->foreign("nom_document")->references('nom_document')->on('documents');
            $table->string("etat_demande")->default("en attente");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_documents');
    }
};
