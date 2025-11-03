<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('brand');
            $table->string('material')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->json('sizes')->nullable(); // Store available sizes as JSON array
            $table->integer('stock')->default(0);
            $table->string('main_image')->nullable();
            $table->json('images')->nullable(); // Additional images
            $table->string('color')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoes');
    }
};
