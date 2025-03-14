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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('usuari')->unique();
            $table->string('nom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('img')->nullable();
            $table->enum('rol', ['client', 'vendedor', 'moderator'])->default('client');
            $table->integer('ofertes')->default(0);
            $table->rememberToken();
            $table->timestamps();
            // direcion envio (tabla aparte) && metodos de pago (tabla aparte)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
