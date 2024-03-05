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
        Schema::create('commerces', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->string('address');
            $table->string('description');
            $table->unsignedBigInteger('verification_token_id');
            $table->foreign('verification_token_id')->references('id')->on('verification_tokens');
            $table->boolean('verificated');
            $table->string('opening_hour');
            $table->string('closing_hour');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerces');
    }
};
