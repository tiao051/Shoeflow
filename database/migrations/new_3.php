<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Kiểm tra xem cột 'New' có tồn tại không (Đảm bảo an toàn)
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'New')) {
            Schema::table('products', function (Blueprint $table) {
                // KHẮC PHỤC LỖI: Cần khai báo lại kiểu dữ liệu (boolean) và giá trị mặc định (default(0))
                // khi dùng renameColumn để Laravel không phải tự động truy vấn lại metadata, 
                // giúp tránh lỗi "Trying to access array offset on value of type null".
                $table->boolean('New')
                      ->default(0) // Giả định giá trị mặc định là 0
                      ->renameColumn('New', 'is_new'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Chỉ hoàn tác nếu cột mới 'is_new' tồn tại
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'is_new')) {
            Schema::table('products', function (Blueprint $table) {
                // Hoàn tác: Cần khai báo lại kiểu dữ liệu (boolean) và giá trị mặc định (default(0))
                $table->boolean('is_new')
                      ->default(0)
                      ->renameColumn('is_new', 'New');
            });
        }
    }
};