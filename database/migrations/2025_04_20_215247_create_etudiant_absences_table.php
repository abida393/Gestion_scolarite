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
            $table->unsignedBigInteger("seance_id");
            $table->unsignedBigInteger("etudiant_id");
            $table->foreign("seance_id")->references("id")->on("seances");
            $table->foreign("etudiant_id")->references("id")->on("etudiants");
            $table->date("date_justif");
            $table->string("justification");
            $table->boolean("justifier")->default(false);
            $table->string("justification_file");
            $table->timestamps();
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
