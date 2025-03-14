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
        Schema::create('direccio_usuaris', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('provincia');
            $table->string('comarca');
            $table->string('direccio');
            $table->string('numero_telefon');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccio_usuaris');
    }
};
