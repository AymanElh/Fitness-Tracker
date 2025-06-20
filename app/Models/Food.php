<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'food_items';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand',
        'portion_default',
        'portions',
        'nutrients',
        'micronutrients',
        'description',
        'image_url',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'portions' => 'array',
        'nutrients' => 'array',
        'micronutrients' => 'array',
        'deleted_at' => 'datetime'
    ];

    public function category() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FoodCategory::class, 'category_id', 'id');
    }

    public function getCaloriesAttribute(): float
    {
        return $this->nutrients['calories'] ?? 0;
    }

    public function getProteinAttribute(): float
    {
        return $this->nutrients['protein_g'] ?? 0;
    }

    public function getCarbsAttribute(): float
    {
        return $this->nutrients['carbs_g'] ?? 0;
    }

    public function getFatAttribute(): float
    {
        return $this->nutrients['fat_g'] ?? 0;
    }
}
