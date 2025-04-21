<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NutritionPlanStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:30',
            'is_public' => 'boolean',
            'days' => 'required|array|min:1',
            'days.*.notes' => 'nullable|string',
            'days.*.meals' => 'nullable|array',
            'days.*.meals.*.meal_id' => 'nullable|exists:meals,id',
            'days.*.meals.*.meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'days.*.meals.*.notes' => 'nullable|string',
            'days.*.foods' => 'nullable|array',
            'days.*.foods.*.food_id' => 'nullable|exists:food_items,id',
            'days.*.foods.*.meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'days.*.foods.*.quantity' => 'required|numeric|min:0.1',
            'days.*.foods.*.quantity_unit' => 'required|string',
            'days.*.foods.*.notes' => 'nullable|string',
        ];
    }
}
