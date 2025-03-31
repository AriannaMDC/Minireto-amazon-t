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
        Schema::create('caracteristiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->json('propietats');
            $table->json('img');
            $table->string('stock')->default('0');
            $table->timestamps();

            $table->foreignId('producte_id')->constrained('productes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristiques'); // Ensure the table is dropped
    }
};
