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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // Foreign key to users table
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Information about the customer
        $table->string('fullname');
        $table->string('phone');
        $table->string('email');
        $table->string('address');
        $table->text('note')->nullable();
        
        // Order information
        $table->string('status')->default('pending'); // pending, processing, completed, cancelled
        $table->string('payment_method'); // cod, banking
        
        // Monetary columns
        $table->decimal('subtotal', 15, 0);
        $table->decimal('shipping_fee', 15, 0)->default(0);
        $table->decimal('tax', 15, 0)->default(0);
        
        // Discount columns
        $table->string('coupon_code')->nullable();
        $table->decimal('discount_amount', 15, 0)->default(0);
        
        // Final total
        $table->decimal('total_amount', 15, 0);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
