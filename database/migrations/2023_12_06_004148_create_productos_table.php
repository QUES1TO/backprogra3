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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("marca");
            $table->string("kilometraje");
            $table->string("año");
            $table->string("combustible");
            $table->string("transmision");
            $table->string("motor");
            $table->string("color");
            $table->string("puertas");
            $table->string("precio");
            $table->string("url_imagen")->nullable();
            $table->unsignedBigInteger('categoria_id');             
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};