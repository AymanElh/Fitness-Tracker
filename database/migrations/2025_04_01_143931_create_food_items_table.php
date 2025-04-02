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
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('food_categories')->onDelete('set null');
            $table->string('brand')->nullable();
            $table->string('portion_default'); // e.g., "100g" or "1 cup"
            $table->jsonb('portions')->nullable(); // Array of available portion options
            $table->jsonb('nutrients'); // Main nutritional information
            $table->jsonb('micronutrients')->nullable(); // Additional nutritional information
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes(); // Allow for soft deletion of food items

            // Index for faster searches
            $table->index('name');
            $table->index('category_id');
            $table->index('brand');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
