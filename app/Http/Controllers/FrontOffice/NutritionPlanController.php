<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\NutritionPlanStore;
use App\Http\Requests\NutritionPlanUpdate;
use App\Models\Food;
use App\Models\Meal;
use App\Models\NutritionPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NutritionPlanController extends Controller
{
    public function index(Request $request): View
    {
        $myPlans = NutritionPlan::where('user_id', auth()->id())
            ->when($request->filled('search'), function($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(9);

        // Get public plans from other users
        $publicPlans = NutritionPlan::where('is_public', true)
            ->where('user_id', '!=', auth()->id())
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(6);

        return view('frontoffice.pages.nutrition-plans.index', compact('myPlans', 'publicPlans'));
    }

    public function create(): View
    {
        $meals = Meal::orderBy('name')->get();
        $foods = Food::orderBy('name')->get();

        return view('frontoffice.pages.nutrition-plans.create', compact('meals', 'foods'));
    }

    public function store(NutritionPlanStore $request)
    {
//        dd($request->all());
        $validated = $request->validated();

        try {
            $nutritionPlan = NutritionPlan::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'duration_days' => $validated['duration_days'],
                'is_public' => $validated['is_public'] ?? false,
            ]);

            foreach ($validated['days'] as $dayIndex => $dayData) {
                $day = $nutritionPlan->days()->create([
                    'day_number' => $dayIndex + 1,
                    'notes' => $dayData['notes'] ?? null,
                ]);

                // Add meals to the day
                if (isset($dayData['meals'])) {
                    foreach ($dayData['meals'] as $mealIndex => $mealData) {
                        $day->meals()->create([
                            'meal_id' => $mealData['meal_id'],
                            'meal_type' => $mealData['meal_type'],
                            'notes' => $mealData['notes'] ?? null,
                            'order' => $mealIndex,
                        ]);
                    }
                }

                if (isset($dayData['foods'])) {
                    foreach ($dayData['foods'] as $foodIndex => $foodData) {
                        $day->foodItems()->create([
                            'food_id' => $foodData['food_id'],
                            'meal_type' => $foodData['meal_type'],
                            'quantity' => $foodData['quantity'],
                            'quantity_unit' => $foodData['quantity_unit'],
                            'notes' => $foodData['notes'] ?? null,
                            'order' => $foodIndex,
                        ]);
                    }
                }
            }

            return redirect()->route('nutrition-plans.show', $nutritionPlan)
                ->with('success', 'Nutrition plan created successfully!');
        } catch (\Exception $e) {
            \Log::error("Error create a new nutrition plan: " . $e->getMessage());
            return back()->withInput()->with('error', 'There was an error creating your nutrition plan: ' . $e->getMessage());
        }
    }

    public function show(NutritionPlan $nutritionPlan)
    {
        if (!$nutritionPlan->is_public && $nutritionPlan->user_id !== auth()->id()) {
            abort(403, 'You do not have permission to view this nutrition plan.');
        }

        // Load relationships
        $nutritionPlan->load([
            'days.meals.meal',
            'days.foodItems.food',
            'user',
        ]);

        return view('frontoffice.pages.nutrition-plans.show', compact('nutritionPlan'));
    }

    public function edit(NutritionPlan $nutritionPlan): View
    {
        if ($nutritionPlan->user_id !== auth()->id()) {
            abort(403, "You don't have permissions to edit this nutrition plan");
        }

        $nutritionPlan->load(['days.meals.meal', 'days.foodItems.food']);
        $meals = MeaL::orderBy('name')->get();
        $foods = Food::orderBy('name')->get();

        return view("frontoffice.pages.nutrition-plans.edit", compact('nutritionPlan', 'meals', 'foods'));
    }

    public function update(NutritionPlanUpdate $request, NutritionPlan $nutritionPlan)
    {
        if ($nutritionPlan->user_id !== auth()->id()) {
            abort(403, "You don't have permission to edit this nutrition plan");
        }

        $validated = $request->validated();
//        dd($validated);
        try {
            $nutritionPlan->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_public' => $validated['is_public'] ?? false
            ]);

            $keepDays = [];

            foreach ($validated['days'] as $index => $data) {
                if (isset($data['id'])) {
                    $day = $nutritionPlan->days()->findOrFail($data['id']);
                    $day->update([
                        'day_number' => $index + 1,
                        'notes' => $data['notes'] ?? null
                    ]);
                    $keepDays[] = $day->id;
                } else {
                    $day = $nutritionPlan->days()->create([
                        'day_number' => $index + 1,
                        'notes' => $data['notes'] ?? null,
                    ]);
                    $keepDays[] = $day->id;
                }

                $keepMealIds = [];

                // Process meals for this day
                if (isset($data['meals'])) {
                    foreach ($data['meals'] as $mealIndex => $mealData) {
                        if (isset($mealData['id'])) {
                            // Update existing meal
                            $meal = $day->meals()->findOrFail($mealData['id']);
                            $meal->update([
                                'meal_id' => $mealData['meal_id'],
                                'meal_type' => $mealData['meal_type'],
                                'notes' => $mealData['notes'] ?? null,
                                'order' => $mealIndex,
                            ]);
                            $keepMealIds[] = $meal->id;
                        } else {
                            // Create new meal
                            $meal = $day->meals()->create([
                                'meal_id' => $mealData['meal_id'],
                                'meal_type' => $mealData['meal_type'],
                                'notes' => $mealData['notes'] ?? null,
                                'order' => $mealIndex,
                            ]);
                            $keepMealIds[] = $meal->id;
                        }
                    }
                }

                $day->meals()->whereNotIn('id', $keepMealIds)->delete();

                $keepFoodIds = [];

                // Process food items for this day
                if (isset($data['foods'])) {
                    foreach ($data['foods'] as $foodIndex => $foodData) {
                        if (isset($foodData['id'])) {
                            // Update existing food item
                            $foodItem = $day->foodItems()->findOrFail($foodData['id']);
                            $foodItem->update([
                                'food_id' => $foodData['food_id'],
                                'meal_type' => $foodData['meal_type'],
                                'quantity' => $foodData['quantity'],
                                'quantity_unit' => $foodData['quantity_unit'],
                                'notes' => $foodData['notes'] ?? null,
                                'order' => $foodIndex,
                            ]);
                            $keepFoodIds[] = $foodItem->id;
                        } else {
                            // Create new food item
                            $foodItem = $day->foodItems()->create([
                                'food_id' => $foodData['food_id'],
                                'meal_type' => $foodData['meal_type'],
                                'quantity' => $foodData['quantity'],
                                'quantity_unit' => $foodData['quantity_unit'],
                                'notes' => $foodData['notes'] ?? null,
                                'order' => $foodIndex,
                            ]);
                            $keepFoodIds[] = $foodItem->id;
                        }
                    }
                }

                $day->foodItems()->whereNotIn('id', $keepFoodIds)->delete();
            }

            $nutritionPlan->days()->whereNotIn('id', $keepDays)->delete();

            // Update the duration_days based on the number of days
            $nutritionPlan->update([
                'duration_days' => count($validated['days']),
            ]);

            return redirect()->route("nutrition-plans.show", $nutritionPlan)
                ->with("success", "Nutrition plan updated successfully");
        } catch (\Exception $e) {
            \Log::error("Error updating plan: " . $e->getMessage());
        }
    }

    public function destroy(NutritionPlan $nutritionPlan)
    {
        if ($nutritionPlan->user_id !== auth()->id()) {
            abort(403, "You don't have permission to delete this nutrition plan.");
        }

        $nutritionPlan->delete();

        return redirect()->route("nutrition-plans.index")->with("success", "Nutrition plan deleted successfully");
    }
}
