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
        Schema::table('postes', function (Blueprint $table) {
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->cascadeOnDelete();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('poste_id')
                ->references('id')->on('postes')
                ->cascadeOnDelete();

            $table->foreign('agence_id')
                ->references('id')->on('agences')
                ->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['poste_id']);
            $table->dropForeign(['agence_id']);
        });

        Schema::table('postes', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });
    }

};
