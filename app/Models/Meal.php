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
            $nutrients = $item->nutrients;

            if (is_string($nutrients)) {
                $decoded = json_decode($nutrients, true);

                if (is_string($decoded)) {
                    $nutrients = json_decode($decoded, true);
                } else {
                    $nutrients = $decoded;
                }
            }

            return $nutrients['calories'] ?? 0;
        });
    }

    /**
     * Get the total protein for this meal.
     */
    public function getTotalProteinAttribute(): float
    {
        return $this->items->sum(function ($item) {
            $nutrients = $item->nutrients;

            if(is_string($nutrients)) {
                $nutrients = json_decode($nutrients, true);
            }
            return $nutrients['protein'];
        });
    }

    /**
     * Get the total carbs for this meal.
     */
    public function getTotalCarbsAttribute(): float
    {
        return $this->items->sum(function ($item) {
            $nutrients = $item->nutrients;

            if(is_string($nutrients)) {
                $nutrients = json_decode($nutrients, true);
            }
            return $nutrients['carbs'];
        });
    }

    /**
     * Get the total fat for this meal.
     */
    public function getTotalFatAttribute(): float
    {
        return $this->items->sum(function ($item) {
            $nutrients = $item->nutrients;

            if(is_string($nutrients)) {
                $nutrients = json_decode($nutrients, true);
            }
            return $nutrients['fat'];
        });
    }
}
