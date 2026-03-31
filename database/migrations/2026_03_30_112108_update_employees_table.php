<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Changer 'sexe' pour correspondre au formulaire
            $table->enum('sexe', ['Homme','Femme'])->nullable()->change();

            // Changer 'permis_de_conduire' en string
            $table->string('permis_de_conduire')->nullable()->change();

            // Ajouter les colonnes manquantes
            if (!Schema::hasColumn('employees', 'lieu_naissance')) {
                $table->string('lieu_naissance')->nullable();
            }

            if (!Schema::hasColumn('employees', 'date_naissance')) {
                $table->date('date_naissance')->nullable();
            }

            // Modifier le status pour correspondre au formulaire
            $table->enum('status', ['actif','demissionnaire','licencie','fin_cdd'])->default('actif')->change();

            // Ajouter matricule unique
            if (!Schema::hasColumn('employees', 'matricule')) {
                $table->string('matricule')->unique()->after('id');
            }

             $table->renameColumn('date_de_naissance', 'date_naissance');
        
            // Ajouter lieu_naissance si manquant
            if (!Schema::hasColumn('employees', 'lieu_naissance')) {
                $table->string('lieu_naissance')->nullable();
            }
            
            // Modifier permis_de_conduire pour correspondre au formulaire (string au lieu de boolean)
            $table->string('permis_de_conduire')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ici tu peux revenir aux anciens types si nécessaire
            $table->enum('sexe', ['H','F'])->nullable()->change();
            $table->boolean('permis_de_conduire')->default(false)->change();
            $table->enum('status', ['actif','inactif'])->default('actif')->change();

            if (Schema::hasColumn('employees', 'lieu_naissance')) {
                $table->dropColumn('lieu_naissance');
            }
            if (Schema::hasColumn('employees', 'date_naissance')) {
                $table->dropColumn('date_naissance');
            }
            if (Schema::hasColumn('employees', 'matricule')) {
                $table->dropColumn('matricule');
            }
        });
    }
};