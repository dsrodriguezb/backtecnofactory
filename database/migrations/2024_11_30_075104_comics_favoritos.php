<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->string('comic_id'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
