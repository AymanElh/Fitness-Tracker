<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalUsersOnThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $percentChange = 0;
        $recentUsers = User::latest()->take(3)->get();

        $totalExercises = Exercise::count();
        $exercisesByType = Exercise::select('type', \DB::raw('count(*) as count'))->groupBy('type')->pluck('count', 'type')->toArray();
        $exercisesByDifficulty = Exercise::select('difficulty', \DB::raw('count(*) as count'))->groupBy('difficulty')->get()->pluck('count', 'difficulty')->toArray();

        $totalMeals = Meal::count();
        $mealsByType = Meal::select('type', \DB::raw('count(*) as count'))->groupBy('type')->get()->pluck('count', 'type')->toArray();
        $avgCaloriesPerMeal = 0;

        $recentActivities = $this->getRecentActivities();
        $userRegistrationData = $this->getUserRegistrationData();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExercises',
            'totalMeals',
            'totalUsersOnThisMonth',
            'exercisesByDifficulty',
            'exercisesByType',
            'mealsByType',
            'percentChange',
            'avgCaloriesPerMeal',
            'recentUsers',
            'recentActivities',
            'userRegistrationData'
        ));
    }

    public function getRecentActivities()
    {
        $activities = collect();

        // Get recent user registrations
        $recentUsers = User::select('id', 'name', 'email', 'created_at')
            ->latest()
            ->take(1)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user_registration',
                    'title' => 'A new user has signed up',
                    'description' => "{$user->name} ({$user->email})",
                    'time' => $user->created_at,
                    'icon_color' => 'indigo'
                ];
            });

        // Get recent meals
        $recentMeals = Meal::select('id', 'name', 'created_at', 'created_by')
            ->with('creator:id,name')
            ->latest()
            ->take(1)
            ->get()
            ->map(function ($meal) {
                return [
                    'type' => 'meal_created',
                    'title' => 'New meal plan created',
                    'description' => "Meal \"{$meal->name}\" added" . ($meal->creator ? " by {$meal->creator->name}" : ""),
                    'time' => $meal->created_at,
                    'icon_color' => 'yellow'
                ];
            });

        // Get recent exercises
        $recentExercises = Exercise::select('id', 'name', 'created_at', 'created_by')
            ->with('creator:id,name')
            ->latest()
            ->take(1)
            ->get()
            ->map(function ($exercise) {
                return [
                    'type' => 'exercise_created',
                    'title' => 'New exercise added',
                    'description' => "Exercise \"{$exercise->name}\" added" . ($exercise->creator ? " by {$exercise->creator->name}" : ""),
                    'time' => $exercise->created_at,
                    'icon_color' => 'green'
                ];
            });

        // Combine all activities and sort by time
        $activities = $activities->concat($recentUsers)
            ->concat($recentMeals)
            ->concat($recentExercises)
            ->sortByDesc('time')
            ->take(3);

        return $activities;
    }

    private function getUserRegistrationData()
    {
        // Get user counts by day for the last 30 days
        $usersByDay = User::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill in days with no registrations
        $dateRange = [];
        $counts = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateRange[] = Carbon::parse($date)->format('M d');
            $counts[] = $usersByDay[$date] ?? 0;
        }

        return [
            'labels' => $dateRange,
            'counts' => $counts
        ];
    }
}
