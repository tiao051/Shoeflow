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
        // Sử dụng Schema::table() để chỉnh sửa bảng products.
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Kiểm tra để tránh lỗi nếu cột đã tồn tại
                if (!Schema::hasColumn('products', 'is_new')) {
                    // Thêm cột boolean 'is_new' với giá trị mặc định là false (0)
                    $table->boolean('is_new')->default(false)->after('is_active');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'is_new')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('is_new');
            });
        }
    }
};