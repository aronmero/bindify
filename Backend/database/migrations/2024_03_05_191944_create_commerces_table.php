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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('description', 300)->default('');
            $table->foreignId('verification_token_id')->nullable()->constrained('tokens')->onDelete('set null');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->boolean('verificated')->default(false);
            $table->string('opening_hour')->nullable();
            $table->string('closing_hour')->nullable();
            $table->boolean('active')->default(true);
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
