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
        // Add 'phone' and 'bio' columns to the 'users' table
        Schema::table('users', function (Blueprint $table) {
            // Ensure the column is nullable as per your validation rules in the controller
            $table->string('phone')->nullable()->after('email');
            $table->text('bio')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the columns if the migration is rolled back
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'bio']);
        });
    }
};