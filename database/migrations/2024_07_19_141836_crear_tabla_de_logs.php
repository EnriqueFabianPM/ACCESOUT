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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // 'Estudiante', 'Empleado', 'Visitante'
            $table->string('action'); // 'Entrada' or 'Salida'
            $table->timestamp('timestamp')->useCurrent();
            $table->foreign('user_id')->references('id')->on('estudiantes')->onDelete('cascade');
            // Add foreign key constraints for empleados and visitantes if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
