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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            
            // Link to user (staff who created it) - using UUID
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            
            // Announcement content
            $table->string('title');
            $table->text('body');
            $table->enum('category', ['general', 'academic', 'exam', 'timetable', 'memo', 'other'])
                ->default('general');
            $table->string('attachment')->nullable(); // File path for attachments
            
            // Visibility and expiry
            $table->enum('visibility', ['public', 'staff', 'student'])->default('public');
              $table->string('target_department')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Tracking
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Laravel defaults
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};