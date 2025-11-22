<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Voucher code, e.g., CONVERSE50');
            $table->string('description')->nullable()->comment('Short description');

            // Discount type: 'fixed' (cash) or 'percent' (%)
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');

            // Discount value: e.g., 50000 (if fixed) or 10 (if percent)
            $table->decimal('discount_value', 15, 0);

            // Minimum order value to use the voucher
            $table->decimal('min_order_value', 15, 0)->default(0);

            // Important for percentage type: Maximum discount amount (e.g., 10% but max 50k)
            // If null, no limit on discount
            $table->decimal('max_discount_amount', 15, 0)->nullable();

            // Quantity management
            $table->integer('quantity')->default(0)->comment('Remaining voucher quantity');
            $table->integer('usage_limit')->default(0)->comment('Total issued quantity (for statistics)');

            // Validity period
            $table->dateTime('start_date')->useCurrent();
            $table->dateTime('end_date');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};