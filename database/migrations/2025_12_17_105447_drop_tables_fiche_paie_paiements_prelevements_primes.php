<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer les tables dans le bon ordre pour éviter les erreurs de contraintes
        Schema::disableForeignKeyConstraints(); // Désactive temporairement les contraintes FK

        Schema::dropIfExists('paiements');      // Paiements dépend de fiche_paie
        Schema::dropIfExists('fiche_paie');     // Maintenant fiche_paie peut être supprimé
        Schema::dropIfExists('prelevements');
        Schema::dropIfExists('primes');

        Schema::enableForeignKeyConstraints();  // Réactive les contraintes FK
    }

    public function down(): void
    {
        // Ici tu peux recréer les tables si besoin
        Schema::create('fiche_paie', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiche_paie_id')->constrained('fiche_paie')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->timestamps();
        });

        Schema::create('prelevements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('montant', 10, 2);
            $table->timestamps();
        });

        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('montant', 10, 2);
            $table->timestamps();
        });
    }
};
