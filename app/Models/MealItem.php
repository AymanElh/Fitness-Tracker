<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MealItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'food_id',
        'quantity',
        'quantity_unit',
        'nutrients',
    ];

    protected $casts = [
        'quantity' => 'float',
        'nutrients' => 'array',
    ];

    /**
     * Get the meal that owns this item.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * Get the food for this meal item.
     */
    public function food(): HasMany
    {
        return $this->hasMany(Food::class, 'food_id');
    }

    /**
     * Calculate nutrients based on quantity when creating or updating a meal item.
     */
    public function calculateNutrients(array $foodNutrients): array
    {
        $nutrients = [];
        $quantity = $this->quantity ?? 1;

        foreach ($foodNutrients as $key => $value) {
            $nutrients[$key] = $value * $quantity;
        }

        return $nutrients;
    }
}
