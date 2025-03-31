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
        Schema::create('metode_pagament', function (Blueprint $table) {
            $table->id();
            $table->enum('tipus', ['visa', 'paypal', 'mastercard']);
            $table->string('titular');
            $table->string('numero');
            $table->string('caducitat');
            $table->string('cvv');
            $table->timestamps();

            $table->foreignId('usuari_id')->constrained('users')->onDelete('cascade');
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
