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
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("centre_id");
            $table->unsignedBigInteger("profile_id");
            $table->unsignedBigInteger("formation_id");
            $table->foreign("centre_id")->references("id")->on("centres");
            $table->foreign("profile_id")->references("type_profile")->on("profiles");
            $table->foreign("formation_id")->references("id")->on("formations");
            $table->string("respo_nom");
            $table->string("respo_prenom");
            $table->string("respo_sex");
            $table->string("respo_nationalite");
            $table->string("respo_cin");
            $table->string("respo_cnss");
            $table->string("respo_diplomes");
            $table->date("respo_date_naissance");
            $table->string("respo_lieu_naissance");
            $table->string("respo_tel");
            $table->string("respo_adresse");
            $table->string("respo_email");
            $table->string("respo_contrat");
            $table->date("respo_date_embauche");
            $table->string("respo_type_paiement");
            $table->string("respo_banque");
            $table->string("respo_rib");
            $table->double("respo_salaire");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
