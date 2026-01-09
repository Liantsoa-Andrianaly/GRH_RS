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
    Schema::create('agences', function (Blueprint $table) {
        $table->id();
        $table->string('code')->nullable();
        $table->string('nom')->nullable();
        $table->string('abreviation')->nullable();
        $table->string('siege')->nullable();
        $table->string('date_creation')->nullable();
        $table->text('photo')->nullable();

        $table->string('mapping')->nullable();
        
       $table->BigInteger('fokotany_id')->nullable();


    $table->string('fcm_token')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
    
};
