<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conges', function (Blueprint $table) {
            $table->integer('solde_restant')->default(0)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('conges', function (Blueprint $table) {
            $table->integer('solde_restant')->nullable()->default(null)->change();
        });
    }
};
