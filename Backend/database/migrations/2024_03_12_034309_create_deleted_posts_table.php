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
        Schema::create('deleted_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('username');
            $table->string('image')->nullable();
            $table->string('title');
            $table->string('description', 300);
            $table->integer('post_type_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('ubicacion');
            $table->string('hashtags');
            $table->datetime('deleted_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_posts');
    }
};
