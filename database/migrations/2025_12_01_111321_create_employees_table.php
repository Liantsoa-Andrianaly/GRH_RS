<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('nom');
            $table->string('prenom');

            $table->enum('sexe', ['H', 'F'])->nullable();
            $table->string('statut_matrimonial')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('adresse')->nullable();

            $table->unsignedBigInteger('poste_id');
            $table->unsignedBigInteger('agence_id');

            $table->string('diplome')->nullable();
            $table->string('cin')->nullable();

            $table->boolean('permis_de_conduire')->default(false);
            $table->string('nationalite')->nullable();

            $table->integer('solde_conge')->default(0);
            $table->enum('status', ['actif', 'inactif'])->default('actif');

            $table->date('date_embauche')->nullable();
            $table->string('photo')->nullable();
            $table->string('telephone')->nullable();
            $table->date('date_de_naissance')->nullable();

            $table->decimal('salaire_base', 10, 2)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
