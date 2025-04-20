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
        Schema::create('enseignant_centres', function (Blueprint $table) {
            $table->unsignedBigInteger('enseignant_id');
            $table->unsignedBigInteger('centre_id');
            $table->foreign('enseignant_id')->references('id')->on('enseignants');
            $table->foreign('centre_id')->references('id')->on('centres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_centres');
    }
};
