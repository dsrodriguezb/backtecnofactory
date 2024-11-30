<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100);
            $table->string('password', 255);
            $table->string('nombre', 150);
            $table->boolean('habilitado');
            $table->boolean('cambiar_password')->nullable();
            $table->string('correo', 100)->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->timestamp('fecha_desactivado')->nullable();
            $table->timestamp('fecha_ultima_modificacion')->nullable();
            $table->timestamp('fecha_ultimo_ingreso')->nullable();
            $table->string('telefono', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
