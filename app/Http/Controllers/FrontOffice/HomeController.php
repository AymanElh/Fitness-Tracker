<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::where('status', 'active')->count(),
            'exercises' => Exercise::count(),
            'foods' => Food::count()
        ];

        $formattedStats = [
            'users' => number_format($stats['users']) . "+",
            'exercises' => number_format($stats['exercises']) . "+",
            'foods' => number_format($stats['foods']) . "+"
        ];

        $exercises = Exercise::take(3)
            ->orderBy('created_at', 'desc')
            ->get();

        $meals = Meal::take(3)
            ->orderBy('created_at', 'desc')
            ->get();

        $foods = Food::with('category')
            ->take(4)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontoffice.pages.home', compact(
            'formattedStats',
            'exercises',
            'foods',
            'meals',
        ));
    }
}
