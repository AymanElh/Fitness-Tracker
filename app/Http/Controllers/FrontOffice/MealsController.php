<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\FoodCategory; // Assuming categories are used for meals
use Illuminate\Http\Request;

class MealsController extends Controller
{
    public function index(Request $request)
    {
        $query = Meal::query();

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginate results
        $meals = $query->paginate(9);

        // Fetch categories for the filter dropdown
        $categories = FoodCategory::all();

        return view('frontoffice.pages.meals', compact('meals', 'categories'));
    }

    public function show(Meal $meal)
    {
        return view('frontoffice.pages.meal-details', compact('meal'));
    }
}
