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
        Schema::create('comentaris', function (Blueprint $table) {
            $table->id();
            $table->integer('valoracio');
            $table->text('comentari');
            $table->json('imatges')->nullable();
            $table->integer('util')->default(0);
            $table->string('model');
            $table->timestamps();

            $table->foreignId('usuari_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producte_id')->constrained('productes')->onDelete('cascade');
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
