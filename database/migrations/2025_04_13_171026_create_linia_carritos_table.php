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
        Schema::create('linia_carritos', function (Blueprint $table) {
            $table->id();
            $table->integer('quantitat');
            $table->decimal('preu', 10, 2);
            $table->decimal('preu_total', 10, 2);
            $table->timestamps();

            $table->foreignId('carrito_id')->constrained('carritos')->onDelete('cascade');
            $table->foreignId('producte_id')->constrained('productes')->onDelete('cascade');
            $table->foreignId('caracteristica_id')->constrained('caracteristiques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linia_carritos');
    }
};
