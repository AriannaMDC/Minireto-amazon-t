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
        Schema::create('valoracions', function (Blueprint $table) {
            $table->id();
            $table->integer('total_comentaris')->default(0);
            $table->decimal('mitja_valoracions', 2, 1)->default(0);
            $table->integer('total_5_estrelles')->default(0);
            $table->integer('total_4_estrelles')->default(0);
            $table->integer('total_3_estrelles')->default(0);
            $table->integer('total_2_estrelles')->default(0);
            $table->integer('total_1_estrelles')->default(0);
            $table->timestamps();

            $table->foreignId('producte_id')->constrained('productes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracions');
    }
};
