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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Category name (e.g., CHUCK TAYLOR)
            $table->string('name');

            // SEO-friendly URL slug (e.g., chuck-taylor)
            $table->string('slug')->unique();

            // Short description displayed under the name (optional)
            $table->string('description')->nullable();

            // Image path for the category (used on the dashboard)
            $table->string('image')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};