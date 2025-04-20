<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExercisePlanDay extends Model
{
    use HasFactory;

    protected $fillable  = [
        'exercise_plan_id',
        'name',
        'day_number',
        'is_rest_day',
        'notes'
    ];

    /**
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(ExercisePlan::class, 'exercise_plan_id');
    }

    /**
     * @return HasMany
     */
    public function exercises(): HasMany
    {
        return $this->hasMany(ExercisePlanItem::class);
    }
}
