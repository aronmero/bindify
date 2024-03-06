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
        Schema::create('posts-hashtags', function (Blueprint $table) {
            $table->foreignId("post_id")->constrained('posts', 'id')->onDelete('cascade');
            $table->foreignId("hashtag_id")->constrained('hashtags', 'id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['post_id', 'hashtag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
