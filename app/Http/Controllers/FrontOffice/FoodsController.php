<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    /**
     * Display a listing of the foods.
     */
    public function index(Request $request)
    {
        $foods = Food::all();

        // Fetch categories for the filter dropdown
        $categories = FoodCategory::all();

        return view('frontoffice.pages.foods', compact('foods', 'categories'));
    }

    /**
     * Display the specified food item.
     */
    public function show(Food $food)
    {
        return view('frontoffice.pages.food-details ', compact('food'));
    }
}
