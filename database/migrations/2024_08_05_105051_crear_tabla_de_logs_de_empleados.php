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
        Schema::create('empleados_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID of the user who made the change
            $table->string('user_email'); // Email of the user who made the change
            $table->string('action'); // Create, Update, Delete
            $table->unsignedBigInteger('empleado_id'); // ID of the employee being changed
            $table->json('old_data')->nullable(); // Old data before the change
            $table->json('new_data')->nullable(); // New data after the change
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); // Ensure 'users' table exists
            $table->foreign('empleado_id')->references('id')->on('empleados'); // Ensure 'empleados' table exists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados_logs');
    }
};
