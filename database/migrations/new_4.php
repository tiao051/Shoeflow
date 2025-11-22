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
        // Use Schema::table() to modify the 'products' table
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                    // Check if 'is_new' column does not already exist (avoid duplicates)
                    if (!Schema::hasColumn('products', 'is_new')) {
                        // Add 'is_new' boolean column with default false (0)
                        $table->boolean('is_new')->default(0)->after('is_active');
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
            // On rollback, drop the column if it exists
    }
};