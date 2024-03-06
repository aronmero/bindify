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
        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignId("user_id")->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId("commerce_id")->constrained('commerces', 'user_id')->onDelete('cascade');
            $table->string('comment', 200)->default('');
            $table->tinyInteger('note');
            $table->timestamps();

            $table->unique(['user_id', 'commerce_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
