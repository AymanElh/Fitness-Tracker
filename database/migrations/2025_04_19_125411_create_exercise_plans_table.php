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
        Schema::create('exercise_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('duration_weeks')->default(4);
            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('exercise_plan_days', function(Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_plan_id')->constrained('exercise_plans')->onDelete('cascade');
            $table->string('name');
            $table->integer('day_number');
            $table->boolean('is_rest_day')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('exercise_plan_items', function(Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_plan_day_id')->constrained('exercise_plan_days')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->string('duration')->nullable();
            $table->integer('order')->default(0);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_plan_items');
        Schema::dropIfExists('exercise_plan_days');
        Schema::dropIfExists('exercise_plans');
    }
};
