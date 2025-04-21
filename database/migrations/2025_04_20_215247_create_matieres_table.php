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
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom_matiere');
            $table->unsignedBigInteger("module_id");
            $table->unsignedBigInteger("enseignant_id");
            $table->unsignedBigInteger("etudiant_id");
            $table->foreign('etudiant_id')->references('id')->on('etudiants');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('enseignant_id')->references('id')->on('enseignants');
            $table->double("note");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
