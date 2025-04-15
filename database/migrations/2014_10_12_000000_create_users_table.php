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
            $table->string('password_confirmation');
            $table->string('img')->nullable()->default(null);
            $table->enum('rol', ['client', 'vendedor', 'admin'])->default('client');
            $table->string('direccio')->nullable();
            // comarca --> string
            // municipi --> string
            // adreça --> string
            $table->boolean('receive_info')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
