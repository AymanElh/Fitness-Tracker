<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionPlanFoodItem extends Model
{
    protected $fillable = [
        'nutrition_plan_day_id',
        'food_id',
        'meal_type',
        'quantity',
        'quantity_unit',
        'notes',
        'order',
    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(NutritionPlanDay::class, 'nutrition_plan_day_id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
