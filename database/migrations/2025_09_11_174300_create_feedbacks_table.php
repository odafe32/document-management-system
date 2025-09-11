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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            
            // User relationships - using UUID
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade'); // student
            $table->foreignUuid('staff_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('subject');
            $table->text('message');
            $table->string('attachment')->nullable(); 
            
            // Status and response
            $table->enum('status', ['pending', 'in_review', 'resolved'])->default('pending');
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            
            // Tracking
            $table->boolean('is_read')->default(false);
            $table->integer('priority')->default(1); // 1=low, 2=medium, 3=high
            
            // Laravel defaults
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};