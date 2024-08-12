<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entradas_y_salidas', function (Blueprint $table) {
            $table->id();
            $table->string('identificador')->index(); // Adding an index to 'identificador'
            $table->enum('tipo', ['estudiante', 'empleado', 'visitante']); // 'tipo' column as enum
            $table->enum('caseta', ['peatonal', 'automovil']); // 'tipo' column as enum
            $table->string('nombre', 255); // Ensuring enough length for names
            $table->string('apellidos', 255); // Ensuring enough length for last names
            $table->datetime('entrada')->nullable();
            $table->datetime('salida')->nullable();
            $table->timestamps(); // Handles 'created_at' and 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas_y_salidas');
    }
};
