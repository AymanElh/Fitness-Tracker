<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nutrition_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_days')->default(7);
            $table->boolean('is_public')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nutrition_plan_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_id')->constrained()->onDelete('cascade');
            $table->integer('day_number');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Each day number should be unique within a plan
            $table->unique(['nutrition_plan_id', 'day_number']);
        });

        Schema::create('nutrition_plan_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_day_id')->constrained()->onDelete('cascade');
            $table->foreignId('meal_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack'])->default('lunch');
            $table->text('notes')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('nutrition_plan_food_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_day_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained('food_items')->onDelete('cascade');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack'])->default('lunch');
            $table->float('quantity')->default(1);
            $table->string('quantity_unit')->default('serving');
            $table->text('notes')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutrition_plan_food_items');
        Schema::dropIfExists('nutrition_plan_meals');
        Schema::dropIfExists('nutrition_plan_days');
        Schema::dropIfExists('nutrition_plans');
    }
};
