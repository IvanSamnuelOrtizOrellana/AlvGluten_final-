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
        Schema::create('product_user', function (Blueprint $table) {
            $table->id();

            // Llave foránea del Usuario (Si borras tu cuenta, se vacía tu carrito)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Llave foránea del Producto (Si borro un pan del sistema, desaparece de los carritos)
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_user');
    }
};
