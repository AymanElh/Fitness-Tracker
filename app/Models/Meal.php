<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'type',
        'created_by',
    ];

    /**
     * Get the user who created this meal.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the items (foods) in this meal.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MealItem::class);
    }

    /**
     * Get the total calories for this meal.
     */
    public function getTotalCaloriesAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->nutrients['calories'] ?? 0;
        });
    }

    /**
     * Get the total protein for this meal.
     */
    public function getTotalProteinAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->nutrients['protein_g'] ?? 0;
        });
    }

    /**
     * Get the total carbs for this meal.
     */
    public function getTotalCarbsAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->nutrients['carbs_g'] ?? 0;
        });
    }

    /**
     * Get the total fat for this meal.
     */
    public function getTotalFatAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->nutrients['fat_g'] ?? 0;
        });
    }

    // In your Meal model, add methods to calculate total nutrition
    public function totalCalories()
    {
        return $this->items->sum(function($item) {
            return $item->food ? $item->food->calories * $item->quantity : 0;
        });
    }
}
