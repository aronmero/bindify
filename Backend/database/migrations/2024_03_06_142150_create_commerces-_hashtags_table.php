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
        Schema::create('commerces-hashtags', function (Blueprint $table) {
            $table->foreignId("commerce_id")->constrained('commerces', 'user_id')->onDelete('cascade');
            $table->foreignId("hashtag_id")->constrained('hashtags', 'id')->onDelete('cascade');
            $table->timestamps();
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
