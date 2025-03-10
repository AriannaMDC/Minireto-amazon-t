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
        Schema::create('productes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('descr');
            $table->decimal('valoracio', 2, 1)->default(0);
            $table->integer('num_resenyes')->default(0);
            $table->decimal('preu', 10, 2);
            $table->decimal('enviament', 10, 2);
            $table->integer('dies');
            $table->boolean('devolucio')->default(false);
            $table->boolean('devolucioGratis')->default(false);
            $table->timestamp('dataAfegit')->useCurrent();
            $table->integer('stock')->default(0);
            $table->foreignId('categoriaId')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
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
