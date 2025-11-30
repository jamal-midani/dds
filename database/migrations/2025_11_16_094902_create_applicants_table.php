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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('age');
            $table->string('education');
            $table->text('experience')->nullable();
            $table->text('skills')->nullable();
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->string('cv_file')->nullable();
            $table->enum('status', ['under_review', 'accepted', 'rejected'])->default('under_review');
            $table->integer('rating')->nullable(); // 1-5 stars
            $table->decimal('score', 5, 2)->nullable(); // Auto-calculated score (0-100)
            $table->text('gemini_summary')->nullable(); // AI-generated summary
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
