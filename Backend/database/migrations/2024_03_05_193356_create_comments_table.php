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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->string('content');
            $table->unsignedBigInteger('father_id')->nullable();
            $table->boolean('active');
            $table->timestamps();

            //clave foranea para el ID del usuario
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //clave foranea para el ID del post
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');;

            //clave foranea para el ID del commentario
            $table->foreign('father_id')->references('id')->on('comments')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
