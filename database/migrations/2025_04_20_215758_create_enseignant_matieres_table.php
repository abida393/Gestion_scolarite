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
        Schema::create('enseignant_matieres', function (Blueprint $table) {
            $table->unsignedBigInteger('enseignant_id');
            $table->unsignedBigInteger('annee_id');
            $table->unsignedBigInteger('matiere_id');
            $table->unsignedBigInteger('groupe_id');
            $table->foreign('enseignant_id')->references('id')->on('enseignants');
            $table->foreign('annee_id')->references('id')->on('annee_universitaires');
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->foreign('groupe_id')->references('id')->on('groupes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_matieres');
    }
};
