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
        Schema::create('etudiant_justifs', function (Blueprint $table) {
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('annee_id');
            $table->foreign('annee_id')->references('id')->on('annee_universitaires');
            $table->boolean("total_justification")->default(false);
            $table->boolean("droit_justification")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant_justifs');
    }
};
