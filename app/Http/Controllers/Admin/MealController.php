<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Food;
use App\Models\MealItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    /**
     * Display a listing of the meals.
     */
    public function index(Request $request)
    {
        $meals = Meal::with('creator')->latest()->paginate(10);

        $totalMeals = Meal::count();
        $avgCalories = [];

        $mealTypeCount = Meal::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
//        dd($meals, $totalMeals, $avgCalories, $mealTypeCount);
        return view('admin.meals.index', compact('meals', 'totalMeals', 'avgCalories', 'mealTypeCount'));
    }

    /**
     * Store a newly created meal in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'image_url' => 'nullable|url',
            'food_items' => 'required|array|min:1',
            'food_items.*.food_id' => 'required|exists:food_items,id',
            'food_items.*.quantity' => 'required|numeric|min:0.01',
            'food_items.*.quantity_unit' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create meal
            $meal = Meal::create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'image_url' => $request->image_url,
                'created_by' => Auth::id(),
            ]);

            // Create meal items
            foreach ($request->food_items as $item) {
                $food = Food::findOrFail($item['food_id']);

                $mealItem = new MealItem([
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'quantity_unit' => $item['quantity_unit'],
                ]);

                // Calculate nutrients based on quantity
                $mealItem->nutrients = $mealItem->calculateNutrients($food->nutrients);

                $meal->items()->save($mealItem);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Meal created successfully',
                'meal' => $meal->load('items.food', 'creator')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create meal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified meal.
     */
    public function show(Meal $meal)
    {
        $meal->load('items.food', 'creator');

        $relatedMeals = Meal::where('type', $meal->type)
            ->where('id', '!=', $meal->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('admin.meals.view', compact('meal', 'relatedMeals'));
    }

    /**
     * Update the specified meal in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'image_url' => 'nullable|url',
            'food_items' => 'required|array|min:1',
            'food_items.*.id' => 'nullable|exists:meal_items,id',
            'food_items.*.food_id' => 'required|exists:food_items,id',
            'food_items.*.quantity' => 'required|numeric|min:0.01',
            'food_items.*.quantity_unit' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update meal
            $meal->update([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'image_url' => $request->image_url,
            ]);

            // Get current item IDs
            $currentItemIds = $meal->items->pluck('id')->toArray();

            // Track item IDs to keep
            $keepItemIds = [];

            // Update or create meal items
            foreach ($request->food_items as $item) {
                $food = Food::findOrFail($item['food_id']);

                if (isset($item['id'])) {
                    // Update existing item
                    $mealItem = MealItem::findOrFail($item['id']);
                    $mealItem->food_id = $food->id;
                    $mealItem->quantity = $item['quantity'];
                    $mealItem->quantity_unit = $item['quantity_unit'];
                    $mealItem->nutrients = $mealItem->calculateNutrients($food->nutrients);
                    $mealItem->save();

                    $keepItemIds[] = $mealItem->id;
                } else {
                    // Create new item
                    $mealItem = new MealItem([
                        'food_id' => $food->id,
                        'quantity' => $item['quantity'],
                        'quantity_unit' => $item['quantity_unit'],
                    ]);

                    $mealItem->nutrients = $mealItem->calculateNutrients($food->nutrients);
                    $meal->items()->save($mealItem);

                    $keepItemIds[] = $mealItem->id;
                }
            }

            // Delete removed items
            $itemsToDelete = array_diff($currentItemIds, $keepItemIds);
            MealItem::whereIn('id', $itemsToDelete)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Meal updated successfully',
                'meal' => $meal->fresh()->load('items.food', 'creator')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update meal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified meal from storage.
     */
    public function destroy(Meal $meal)
    {
        try {
            $meal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Meal deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete meal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search for foods to add to a meal.
     */
    public function searchFoods(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10);

        $foods = Food::where('name', 'like', "%{$search}%")
            ->orderBy('name')
            ->limit($limit)
            ->get(['id', 'name', 'image_url', 'nutrients', 'category_id']);

        return response()->json([
            'success' => true,
            'foods' => $foods
        ]);
    }

    /**
     * Get meal statistics for the dashboard.
     */
    public function getStats()
    {
        try {
            $totalMeals = Meal::count();

            $avgCalories = round(DB::table('meal_items')
                ->select(DB::raw('AVG(JSON_EXTRACT(nutrients, "$.calories")) as avg_calories'))
                ->first()?->avg_calories ?? 0);

            $mealTypeCount = Meal::select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray();

            return response()->json([
                'success' => true,
                'stats' => [
                    'totalMeals' => $totalMeals,
                    'avgCalories' => $avgCalories,
                    'mealTypeCount' => $mealTypeCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
