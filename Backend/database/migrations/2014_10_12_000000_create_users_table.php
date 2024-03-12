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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->unsignedBigInteger('municipality_id');
            $table->string('avatar')->nullable()->default('default');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('banner')->nullable()->default('default');
            $table->rememberToken();
            $table->timestamps();

            //clave foranea para el ID del municipio
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        Schema::dropIfExists('users');
    }
};
