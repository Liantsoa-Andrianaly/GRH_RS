<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('employee_id');
    $table->unsignedBigInteger('poste_ancien_id')->nullable();
    $table->unsignedBigInteger('poste_nouveau_id');

    $table->timestamp('date_creation')->useCurrent();

    $table->unsignedBigInteger('user_id')->nullable();

    $table->timestamps();

    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    $table->foreign('poste_ancien_id')->references('id')->on('postes')->nullOnDelete();
    $table->foreign('poste_nouveau_id')->references('id')->on('postes')->onDelete('cascade');
   
    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
});

    }

    public function down()
    {
        Schema::dropIfExists('affectations');
    }
};
