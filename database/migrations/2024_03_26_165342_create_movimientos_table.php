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
        // Schema::create('movimientos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('folio', 255);
        //     $table->enum('tipo_moviento', ['RESGUARDO', 'DEVOLUCION', 'ACTUALIZACION', 'ALTA', 'BAJA',]);
        //     $table->date('fecha');
        //     $table->text('observaciones')->nullable();

        //     // 

        //     $table->unsignedBigInteger('bien_id')->nullable(); // Clave foránea que hace referencia al id de la tabla biens
        //     $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');

        //     $table->unsignedBigInteger('personal_id')->nullable(); // Clave foránea que hace referencia al id de la tabla biens
        //     $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');

        //     //$table->unsignedBigInteger('folio_id')->nullable(); // Clave foránea que hace referencia al id de la tabla biens
        //     // $table->foreign('folio_id')->references('id')->on('folios')->onDelete('cascade');
        //     $table->timestamps();
        // });

        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 255)->unique(); // Cada folio debe ser único
            $table->enum('tipo_moviento', ['RESGUARDO', 'DEVOLUCION', 'ACTUALIZACION', 'ALTA', 'BAJA', 'REGISTRO','CANCELACION']);
            $table->date('fecha');
            $table->date('fecha_termino')->nullable();
            $table->text('observaciones')->nullable();

            $table->enum('estado', ['COMPLETO', 'PARCIAL', 'TERMINADO', 'CANCELADO','N/A'])->default('COMPLETO')->nullable();
            $table->decimal('cantidad', 10, 2)->nullable();
            $table->json('datosJSON')->nullable();

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
        Schema::dropIfExists('movimientos');
    }
};
