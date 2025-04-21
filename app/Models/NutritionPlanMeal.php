<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionPlanMeal extends Model
{
    protected $fillable = [
        'nutrition_plan_day_id',
        'meal_id',
        'meal_type',
        'notes',
        'order',
    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(NutritionPlanDay::class, 'nutrition_plan_day_id');
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
