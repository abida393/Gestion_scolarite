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
        Schema::create('annee_formations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("formation_id");
            $table->unsignedBigInteger("annee_id");
            $table->foreign("annee_id")->references('id')->on('annee');
            $table->foreign('formation_id')->references('id')->on('formations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annee_formations');
    }
};
