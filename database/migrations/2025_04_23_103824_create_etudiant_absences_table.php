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
        Schema::create('etudiant_absences', function (Blueprint $table) {
    $table->id();
    $table->foreignId('emploi_temps_id')->constrained('emplois_temps');
    $table->foreignId('etudiant_id')->constrained('etudiants');
    $table->date('date_absence');
    $table->date('date_justif')->nullable();
    $table->enum('type', ['absence', 'retard'])->default('absence');
    $table->integer('duree_minutes')->nullable(); // Pour retard/sortie
    $table->boolean('Justifier')->default(false);
    $table->text('justification');
    $table->string('justification_file')->nullable();  // Type MIME (pdf, jpg, etc.)
    $table->timestamps();
$table->enum('status', ['pending', 'approved', 'rejected','non_justifier'])->default('pending'); // Ajoute cette ligne
    $table->index(['etudiant_id', 'date_absence']);
    $table->index(['emploi_temps_id', 'date_absence']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant_absences');
    }

};
