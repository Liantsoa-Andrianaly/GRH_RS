<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Renommer la colonne date_de_naissance en date_naissance
            if (Schema::hasColumn('employees', 'date_de_naissance')) {
                $table->renameColumn('date_de_naissance', 'date_naissance');
            }

            // Ajouter le lieu de naissance
            if (!Schema::hasColumn('employees', 'lieu_naissance')) {
                $table->string('lieu_naissance')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Annuler les changements
            if (Schema::hasColumn('employees', 'date_naissance')) {
                $table->renameColumn('date_naissance', 'date_de_naissance');
            }

            if (Schema::hasColumn('employees', 'lieu_naissance')) {
                $table->dropColumn('lieu_naissance');
            }
        });
    }
};
