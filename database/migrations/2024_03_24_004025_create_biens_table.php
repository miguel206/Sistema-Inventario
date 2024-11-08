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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('numero_inventario', 255)->nullable();
            $table->string('numero_serie', 255)->nullable();
            $table->string('descripcion', 255);
            $table->string('modelo', 255);
            $table->string('marca', 255);
            //$table->decimal('precio', 10, 2)->nullable();
            $table->decimal('precio', 8, 2)->nullable()->default(0);
            $table->string('factura')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['DISPONIBLE', 'RESGUARDO', 'BAJA', 'MANTENIMIENTO'])->default('DISPONIBLE');

            //nuevo agregado en 12/06/24
            $table->date('fecha_ingreso');

            $table->date('fecha_baja')->nullable();
            $table->string('documento')->nullable();

            $table->unsignedBigInteger('personal_id')->nullable(); // Clave foránea que hace referencia al id de la tabla biens
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
