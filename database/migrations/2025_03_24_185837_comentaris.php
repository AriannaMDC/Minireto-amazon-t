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
            $table->timestamps();
            $table->tinyInteger('valoracio');
            $table->text('text');
            $table->json('img')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->integer('util')->default(0);
            $table->string('model');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentaris');
    }
};
