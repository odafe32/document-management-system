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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            
            // Link to user (staff who uploaded it) - using UUID
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            
            // Document info
            $table->string('title'); // Document title
            $table->text('description')->nullable(); // Optional notes
            $table->enum('category', ['lecture', 'timetable', 'memo', 'other'])
                ->default('other'); // Document type
            $table->string('file_path'); // Storage path
            $table->enum('visibility', ['public', 'private']) // Who can view
                ->default('public');
            
            // Tracking
            $table->unsignedBigInteger('downloads')->default(0); // Track downloads
            
            // Laravel defaults
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};