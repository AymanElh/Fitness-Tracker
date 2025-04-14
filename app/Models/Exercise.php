<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'muscle_group',
        'equipment',
        'difficulty',
        'duration',
        'calories_burned',
        'image_url',
        'video_url',
        'created_by',
    ];

    /**
     * Get the user who created this exercise.
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get exercise type options
     */
    public static function getTypeOptions(): array
    {
        return [
            'strength' => 'Strength',
            'cardio' => 'Cardio',
            'flexibility' => 'Flexibility',
            'balance' => 'Balance',
            'plyometric' => 'Plyometric',
            'functional' => 'Functional'
        ];
    }

    /**
     * Get muscle group options
     */
    public static function getMuscleGroupOptions(): array
    {
        return [
            'chest' => 'Chest',
            'back' => 'Back',
            'shoulders' => 'Shoulders',
            'arms' => 'Arms',
            'core' => 'Core',
            'legs' => 'Legs',
            'full_body' => 'Full Body'
        ];
    }

    /**
     * Get difficulty options
     */
    public static function getDifficultyOptions(): array
    {
        return [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced'
        ];
    }
}
