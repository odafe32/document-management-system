<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            // Add admin_id column
            $table->uuid('admin_id')->nullable()->after('user_id');
            
            // Add assigned_at timestamp
            $table->timestamp('assigned_at')->nullable()->after('replied_at');
            
            // Add foreign key constraint
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });

        // Migrate existing staff_id data to admin_id
        DB::statement('UPDATE feedbacks SET admin_id = staff_id WHERE staff_id IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['admin_id']);
            
            // Drop the columns
            $table->dropColumn(['admin_id', 'assigned_at']);
        });
    }
};