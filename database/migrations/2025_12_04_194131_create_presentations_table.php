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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_id')->constrained('masters')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->string('day_hold')->nullable();
            $table->time('start_time')->nullable();
            $table->time('finish_time')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');

            $table->timestamps();

            $table->index('day_hold');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
