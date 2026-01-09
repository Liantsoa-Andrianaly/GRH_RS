<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        // 1. Ajouter d'abord la colonne nullable
        $table->string('matricule')->nullable()->after('id');
    });
}


public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn('matricule');
    });
}

};
