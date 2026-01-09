<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    \App\Models\Employee::whereNull('statut_matrimonial')
        ->update(['statut_matrimonial' => 'Célibataire']);
}

public function down(): void
{
    // Optionnel : remettre à null si besoin
    \App\Models\Employee::where('statut_matrimonial', 'Célibataire')
        ->update(['statut_matrimonial' => null]);
}

};
