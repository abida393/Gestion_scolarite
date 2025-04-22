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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("classe_id");
            $table->foreign("classe_id")->references("id")->on("classes");
            $table->string("nom_module");
            $table->boolean("status");
            $table->integer("nbr_matiere");
            $table->unsignedBigInteger("note_general");
            $table->foreign("note_generale")->references("note_general")->on("examens");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
