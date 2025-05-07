<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodStoreRequest;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mockery\Exception;

class FoodController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        try {
            $foods = Food::with('category')->latest()->get();

            // Get statistics
            $totalFoods = $foods->count();
            $categoryCount = $foods->pluck('category')->filter()->unique()->count();
            $avgCalories = $foods->avg(function ($food) {
                return $food->nutrients['calories'] ?? 0;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'totalFoods' => $totalFoods,
                    'categoryCount' => $categoryCount,
                    'avgCalories' => round($avgCalories),
                    'currentDateTime' => now()->format('Y-m-d H:i:s'),
                    'currentUser' => auth()->user()->name,
                    'foods' => $foods
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error fetching food items: " . $e->getMessage());
            return back()->withErrors(['error' => "Error getting food items"]);
        }
    }

    public function store(FoodStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            \Log::info("Retrieved Data: ", $request->all());

            // Create the food item
            $foodItem = new Food([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category,
                'portion_default' => $request->portion_default,
                'nutrients' => [
                    'calories' => $request->nutrients['calories'],
                    'protein_g' => $request->nutrients['protein_g'],
                    'carbs_g' => $request->nutrients['carbs_g'],
                    'fat_g' => $request->nutrients['fat_g'],
                    'fiber_g' => $request->nutrients['fiber_g'] ?? 0,
                    'sugar_g' => $request->nutrients['sugar_g'] ?? 0,
                ],
                'description' => $request->description,
                'created_by' => auth()->id(),
            ]);
            \Log::info($foodItem);
            $foodItem->save();
            $foodItem->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Food item created successfully.',
                'food' => $foodItem,
            ]);
        } catch (Exception $e) {
            \Log::error("Error creating food item: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error creating food item: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get food item data for AJAX requests.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFoodData(int $id): \Illuminate\Http\JsonResponse
    {

        try {
            $food = Food::find($id);
            // Load the category relationship
            $food->load('category');

            return response()->json([
                'success' => true,
                'food' => $food
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Food item not found'
            ], 404);
        }
    }

    public function update(Request $request, int $foodId): \Illuminate\Http\JsonResponse
    {
        try {
            \Log::info("Validated Request data: ", $request->all());
            // Validation is handled by FoodStoreRequest

            $food = Food::find($foodId);
            // Update slug if name changed
            if ($food->name !== $request->name) {
                $food->slug = Str::slug($request->name);
            }

            // Update the food item
            $food->update([
                'name' => $request->name,
                'category_id' => $request->category,
                'portion_default' => $request->portion_default,
                'nutrients' => [
                    'calories' => $request->nutrients['calories'],
                    'protein_g' => $request->nutrients['protein_g'],
                    'carbs_g' => $request->nutrients['carbs_g'],
                    'fat_g' => $request->nutrients['fat_g'],
                    'fiber_g' => $request->nutrients['fiber_g'] ?? 0,
                    'sugar_g' => $request->nutrients['sugar_g'] ?? 0,
                ],
                'description' => $request->description,
            ]);

            // Reload the food with its category
            $food->load('category');

            // Return success response with updated food
            return response()->json([
                'success' => true,
                'message' => "Food item '{$food->name}' updated successfully",
                'food' => $food
            ]);

        } catch (\Exception $e) {
            \Log::error("Error updating food item: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error updating food item: " . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(int $foodId): \Illuminate\Http\JsonResponse
    {
        try {
            $food = Food::find($foodId);
            \Log::info("Deleting Food: " . $food);
            $name = $food->name;
            $food->delete();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => "Food item '{$name}' deleted successfully",
                'id' => $food->id
            ]);

        } catch (\Exception $e) {
            \Log::error("Error deleting food item: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error deleting food item: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get food item statistics
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats(): \Illuminate\Http\JsonResponse
    {
        try {
            $foods = Food::all();
            $totalFoods = $foods->count();
            $categoryCount = FoodCategory::count();
            $avgCalories = $foods->avg(function ($food) {
                return $food->nutrients['calories'] ?? 0;
            });

            return response()->json([
                'success' => true,
                'stats' => [
                    'totalFoods' => $totalFoods,
                    'categoryCount' => $categoryCount,
                    'avgCalories' => round($avgCalories),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error fetching food stats: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error fetching statistics"
            ], 500);
        }
    }

    public function show(Food $food)
    {
        $food->load(['category']);

        // Get related foods (same category, limited to 6)
        $relatedFoods = Food::where('category_id', $food->category_id)
            ->where('id', '!=', $food->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('admin.foods.show', [
            'food' => $food,
            'relatedFoods' => $relatedFoods
        ]);
    }
}
