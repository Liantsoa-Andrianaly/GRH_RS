<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->unsignedBigInteger('agence_ancien_id')->nullable()->after('poste_ancien_id');
            $table->unsignedBigInteger('agence_nouveau_id')->nullable()->after('poste_nouveau_id');

            // Clés étrangères
            $table->foreign('agence_ancien_id')->references('id')->on('agences')->nullOnDelete();
            $table->foreign('agence_nouveau_id')->references('id')->on('agences')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->dropForeign(['agence_ancien_id']);
            $table->dropForeign(['agence_nouveau_id']);
            $table->dropColumn(['agence_ancien_id', 'agence_nouveau_id']);
        });
    }
};
