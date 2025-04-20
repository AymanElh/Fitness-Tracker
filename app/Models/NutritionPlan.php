<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'duration_days',
        'is_public',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(NutritionPlanDay::class)->orderBy('day_number');
    }

    public function getTotalCaloriesAttribute()
    {
        $total = 0;
        foreach ($this->days as $day) {
            $total += $day->total_calories;
        }
        return $total;
    }

    public function getDailyAverageCaloriesAttribute(): float|int
    {
        if ($this->duration_days <= 0) return 0;
        return round($this->total_calories / $this->duration_days);
    }
}
