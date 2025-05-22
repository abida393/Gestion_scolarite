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
        Schema::create('emplois_temps', function (Blueprint $table) {
            $table->id();
            $table->string('jour');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->unsignedBigInteger('matiere_id');
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->unsignedBigInteger('enseignant_id');
            $table->foreign('enseignant_id')->references('id')->on('enseignants');
            $table->string('salle');
            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')->references('id')->on('classes');
         $table->enum('statut', ['normal', 'annule', 'reporte'])
    ->default('normal');
$table->text('motif_annulation')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emplois_temps');
    }
};
