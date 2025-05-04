<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NutritionPlanDay extends Model
{
    protected $fillable = [
        'nutrition_plan_id',
        'day_number',
        'notes',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(NutritionPlan::class, 'nutrition_plan_id');
    }

    public function meals(): HasMany
    {
        return $this->hasMany(NutritionPlanMeal::class)->orderBy('meal_type')->orderBy('order');
    }

    public function foodItems(): HasMany
    {
        return $this->hasMany(NutritionPlanFoodItem::class)->orderBy('meal_type')->orderBy('order');
    }

    public function getTotalCaloriesAttribute()
    {
        $mealCalories = $this->meals->sum(function($meal) {
            return $meal->meal ? $meal->meal->totalCalories : 0;
        });

        $foodCalories = $this->foodItems->sum(function($item) {
            return $item->food ? $item->quantity * $item->food->calories : 0;
        });

        return $mealCalories + $foodCalories;
    }

    public function getBreakfastItemsAttribute(): \Illuminate\Support\Collection
    {
        return $this->combineItems('breakfast');
    }

    public function getLunchItemsAttribute(): \Illuminate\Support\Collection
    {
        return $this->combineItems('lunch');
    }

    public function getDinnerItemsAttribute(): \Illuminate\Support\Collection
    {
        return $this->combineItems('dinner');
    }

    public function getSnackItemsAttribute(): \Illuminate\Support\Collection
    {
        return $this->combineItems('snack');
    }

    protected function combineItems($mealType): \Illuminate\Support\Collection
    {
        $items = collect();

        // Add meals
        $this->meals->where('meal_type', $mealType)->each(function($meal) use ($items) {
            $items->push([
                'type' => 'meal',
                'data' => $meal
            ]);
        });

        // Add individual food items
        $this->foodItems->where('meal_type', $mealType)->each(function($food) use ($items) {
            $items->push([
                'type' => 'food',
                'data' => $food
            ]);
        });

        return $items->sortBy('data.order');
    }
}
