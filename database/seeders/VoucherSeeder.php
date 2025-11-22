<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Fixed amount discount for large orders (Encourage bulk purchases)
        Voucher::create([
            'code' => 'CONVERSE50',
            'description' => '50k discount for orders over 1,000,000 VND',
            'discount_type' => 'fixed',
            'discount_value' => 50000,
            'min_order_value' => 1000000,
            'max_discount_amount' => null,
            'quantity' => 100,
            'usage_limit' => 100,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(1),
            'is_active' => true,
        ]);

        // 2. Welcome voucher for new members (Encourage first-time purchases)
        Voucher::create([
            'code' => 'WELCOME10',
            'description' => '10% discount on the first order (Max 50k)',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'min_order_value' => 500000,
            'max_discount_amount' => 50000,
            'quantity' => 500,
            'usage_limit' => 500,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(1),
            'is_active' => true,
        ]);

        // 3. Free shipping voucher (Offset shipping costs)
        Voucher::create([
            'code' => 'FREESHIP',
            'description' => '30k shipping support for all orders',
            'discount_type' => 'fixed',
            'discount_value' => 30000,
            'min_order_value' => 0,
            'max_discount_amount' => null,
            'quantity' => 200,
            'usage_limit' => 200,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        // 4. VIP voucher for high-value orders (High-end customers)
        Voucher::create([
            'code' => 'VIPMEMBER',
            'description' => '200k discount for orders over 3,000,000 VND',
            'discount_type' => 'fixed',
            'discount_value' => 200000,
            'min_order_value' => 3000000,
            'max_discount_amount' => null,
            'quantity' => 20,
            'usage_limit' => 20,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(7),
            'is_active' => true,
        ]);

        // 5. High percentage discount with strict conditions (Black Friday style)
        Voucher::create([
            'code' => 'SALE20',
            'description' => '20% discount (Max 100k) for orders over 2,000,000 VND',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'min_order_value' => 2000000,
            'max_discount_amount' => 100000,
            'quantity' => 50,
            'usage_limit' => 50,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(1),
            'is_active' => true,
        ]);
    }
}