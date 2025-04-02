<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        try {
            $foods = Food::all();

            // Get statistics
            $totalFoods = $foods->count();
            $categoryCount = $foods->pluck('category')->filter()->unique()->count();
            $avgCalories = $foods->avg(function ($food) {
                return $food->nutrients['calories'] ?? 0;
            });
//            dd($foods);
            return view('admin.foods.index', [
                'foods' => $foods,
                'totalFoods' => $totalFoods,
                'categoryCount' => $categoryCount,
                'avgCalories' => round($avgCalories),
                'currentDateTime' => now()->format('Y-m-d H:i:s'),
                'currentUser' => auth()->user()->name
            ]);
        } catch (\Exception $e) {
            \Log::error("Error fetching food items: " . $e->getMessage());
            return back()->withErrors(['error' => "Error getting food items"]);
        }
    }


}
