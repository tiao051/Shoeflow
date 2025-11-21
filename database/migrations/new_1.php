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
        // Kiểm tra xem bảng 'carts' có tồn tại hay không trước khi thêm cột
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                // Thêm cột 'user_id' dưới dạng khóa ngoại không dấu (unsigned)
                // Nó tham chiếu đến cột 'id' trong bảng 'users'.
                $table->foreignId('user_id')
                      ->nullable() // Có thể cho phép null nếu bạn xử lý giỏ hàng khách vãng lai
                      ->constrained() // Tạo ràng buộc khóa ngoại với bảng 'users'
                      ->after('id') // Đặt sau cột 'id'
                      ->onDelete('cascade'); // Xóa giỏ hàng nếu người dùng bị xóa (tùy chọn)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                // Xóa ràng buộc khóa ngoại trước
                $table->dropForeign(['user_id']);
                // Xóa cột 'user_id'
                $table->dropColumn('user_id');
            });
        }
    }
};