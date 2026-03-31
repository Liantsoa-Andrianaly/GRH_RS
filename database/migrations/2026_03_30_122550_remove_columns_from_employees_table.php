<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['photo', 'date_de_naissance']); 
            // remplace par les colonnes que tu veux supprimer
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('photo')->nullable();
            $table->string('date_de_naissance')->nullable();
            // remettre les colonnes si tu fais un rollback
        });
    }
};