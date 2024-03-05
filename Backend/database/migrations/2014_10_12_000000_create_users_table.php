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
            $table->string('avatar')->nullable();
            $table->string('username')->unique();
            $table->string('nombre')->unique();
            $table->rememberToken();
            $table->timestamps();

            //clave foranea para el ID del municipio
            $table->foreign('municipality_id')->references('id')->on('municipalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropForeign(['municipality_id']);
            $table->dropColumn('municipality_id');
        });
        Schema::dropIfExists('users');
    }
};
