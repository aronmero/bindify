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
        Schema::create('deleted_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->foreignId("user_id")->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId("commerce_id")->constrained('users', 'id')->onDelete('cascade');
            $table->string('comment', 200);
            $table->tinyInteger('note');
            $table->datetime('deleted_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_reviews');
    }
};
