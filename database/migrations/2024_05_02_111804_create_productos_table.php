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
            $table->integer('id_producto');
            $table->string('nombre1');
            $table->string('nombre2');
            $table->double('precio');
            $table->double('precio2')->nullable();
           /*  $table->integer('cantidad');
            $table->double('precio_total');
            $table->double('iva'); */
            $table->text('comentario');
            //servicio extra
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
