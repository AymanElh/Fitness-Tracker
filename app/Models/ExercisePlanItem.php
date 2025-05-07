<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Fluent\Concerns\Has;

class ExercisePlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_plan_day_id',
        'exercise_id',
        'sets',
        'reps',
        'duration',
        'order',
        'notes',
    ];

    /**
     * @return BelongsTo
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(ExercisePlanDay::class, 'exercise_plan_day_id');
    }

    /**
     * @return BelongsTo
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
