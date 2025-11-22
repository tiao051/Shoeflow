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
        // Check if the 'New' column exists (safety check)
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'New')) {
            Schema::table('products', function (Blueprint $table) {
                // Fix: ensure correct data type (boolean) and default(0)
                // when renaming columns so Laravel doesn't re-query metadata,
                // which avoids "Trying to access array offset on value of type null" errors.
                $table->boolean('New')
                      ->default(0) // assume default value is 0
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
        // Only rollback if the new 'is_new' column exists
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'is_new')) {
            Schema::table('products', function (Blueprint $table) {
                // Rollback: ensure data type (boolean) and default(0) before renaming
                $table->boolean('is_new')
                      ->default(0)
                      ->renameColumn('is_new', 'New');
            });
        }
    }
};