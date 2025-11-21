<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This will add the 'avatar' column to the 'users' table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the 'avatar' column, which will store the path to the user's avatar image.
            // It is nullable because existing users won't have an avatar initially.
            $table->string('avatar')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This will remove the 'avatar' column if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the column if it exists to allow for safe rollback
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });
    }
};