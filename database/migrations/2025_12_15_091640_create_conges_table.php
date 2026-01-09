<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasTable('conges')) {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('type')->default('payé');
            $table->string('motif')->nullable();
            $table->string('statut')->default('en_attente');
            $table->string('commentaire_validation')->nullable();
            $table->integer('nombre')->nullable();
            $table->integer('solde_restant')->nullable();
            $table->timestamps();
        });
    }
}


    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
