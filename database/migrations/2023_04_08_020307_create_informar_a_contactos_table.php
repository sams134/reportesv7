<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('informar_a_contactos');
        Schema::create('informar_a_contactos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        
            $table->integer('id_motor')->unsigned()->length(10);
            $table->foreign('id_motor')->references('id_motor')->on('motors')->onDelete('cascade');
        
            $table->integer('id_contacto')->unsigned()->length(10);
            $table->foreign('id_contacto')->references('id')->on('contactos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informar_a_contactos');
    }
};
