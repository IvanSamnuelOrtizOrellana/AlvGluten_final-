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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); //relacion 1:N de las categorias
            $table->string('name');
            $table->text('description');
            $table->decimal('price',8, 2) ;
            $table->boolean('is_gluten_free')->default(true); // para que salga un anuncio si es sin gluten por los fabricantes
            $table->timestamps();
            $table->softDeletes();//Borrado logico

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
