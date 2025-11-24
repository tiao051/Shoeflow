<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('color');
            
            $table->decimal('price', 15, 0); // Giá VND
            $table->decimal('sale_price', 15, 0)->nullable();
            
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            $table->integer('stock')->default(0);
            
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);
            
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};