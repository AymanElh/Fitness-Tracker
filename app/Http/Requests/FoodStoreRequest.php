<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FoodStoreRequest extends FormRequest
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
    public function rules(Request $request): array
    {
//        \Log::info($request->all());
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Fix: Properly handle the unique rule with quotes and null checking
                $this->food
                    ? 'unique:food_items,name,'.$this->food->id
                    : 'unique:food_items,name'
            ],
            'category' => ['required', 'exists:food_categories,id'],
            'portion_default' => ['required', 'string', 'max:255'],
            'nutrients.calories' => ['required', 'numeric', 'min:0'],
            'nutrients.protein_g' => ['required', 'numeric', 'min:0'],
            'nutrients.carbs_g' => ['required', 'numeric', 'min:0'],
            'nutrients.fat_g' => ['required', 'numeric', 'min:0'],
            'nutrients.fiber_g' => ['nullable', 'numeric', 'min:0'],
            'nutrients.sugar_g' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category.required' => 'Please select a food category.',
            'category.exists' => 'The selected category does not exist.',
            'nutrients.calories.required' => 'The calories field is required.',
            'nutrients.protein_g.required' => 'The protein field is required.',
            'nutrients.carbs_g.required' => 'The carbohydrates field is required.',
            'nutrients.fat_g.required' => 'The fat field is required.',
        ];
    }
}
