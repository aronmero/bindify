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
        Schema::create('followers', function (Blueprint $table) {
           

            $table->unsignedBigInteger('follows_id');
            $table->unsignedBigInteger('follower_id');
            $table->timestamps();

            //clave foranea para el ID del usuario que sigue
            $table->foreign('follows_id')->references('id')->on('users')->onDelete('cascade');
            
            //clave foranea para el ID del usuario al  que siguen
             $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
