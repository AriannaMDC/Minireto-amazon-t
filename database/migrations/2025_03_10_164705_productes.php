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
            $table->decimal('preu', 10, 2);
            $table->decimal('enviament', 10, 2);
            $table->integer('dies');
            $table->boolean('devolucio')->default(false);
            $table->boolean('devolucioGratis')->default(false);
            $table->timestamp('dataAfegit')->useCurrent();
            $table->boolean('destacat')->default(false);
            $table->timestamps();

            $table->foreignId('categoria_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('vendedor_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productes');
    }
};
