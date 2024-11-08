<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimiento_bien', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movimiento_id');
            $table->unsignedBigInteger('bien_id');

            $table->boolean('devuelto')->default(false); 
            
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade');
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_bien');
    }
};
