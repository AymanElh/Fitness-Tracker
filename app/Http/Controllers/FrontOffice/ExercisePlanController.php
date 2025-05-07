<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExercisePlan;
use App\Models\ExercisePlanDay;
use App\Models\ExercisePlanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExercisePlanController extends Controller
{
    public function index(): View
    {
        $plans = ExercisePlan::where('user_id', Auth::id())->latest()->get();
        $publicPlans = ExercisePlan::where('is_public', true)
            ->where('user_id', '!=', Auth::id())
            ->latest()
            ->get();
        return view('frontoffice.pages.exercise-plans.index', [
            'plans' => $plans,
            'publicPlans' => $publicPlans
        ]);
    }

    public function show(ExercisePlan $plan): View
    {
        if ($plan->user_id !== Auth::id() && !$plan->is_public) {
            abort(403, "You can't see this plan");
        }

        return view('frontoffice.pages.exercise-plans.show', [
            'plan' => $plan->load('days.exercises.exercise')
        ]);
    }

    public function create(): View
    {
        return view('frontoffice.pages.exercise-plans.create');
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'is_public' => 'boolean'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_public'] = $request->has('is_public');
//        dd($validated);
        $plan = ExercisePlan::create($validated);

        return redirect()->route('exercise-plans.edit', $plan)
            ->with('success', 'Exercise plan created successfully! Now let\'s add some workouts.');
    }

    public function edit(ExercisePlan $plan): View
    {
        // Check if the plan belongs to the user
        if ($plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $exercises = Exercise::all();

        return view('frontoffice.pages.exercise-plans.edit', [
            'plan' => $plan->load('days.exercises.exercise'),
            'exercises' => $exercises
        ]);
    }

    public function update(Request $request, ExercisePlan $plan)
    {
        // Check if the plan belongs to the user
        if ($plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'is_public' => 'boolean',
        ]);

        $validated['is_public'] = $request->has('is_public');

        $plan->update($validated);

        return redirect()->route('exercise-plans.edit', $plan)
            ->with('success', 'Exercise plan updated successfully!');
    }

    public function destroy(ExercisePlan $plan)
    {
        // Check if the plan belongs to the user
        if ($plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to delete this plan');
        }

        $plan->delete();

        return redirect()->route('exercise-plans.index')
            ->with('success', 'Exercise plan deleted successfully!');
    }

    public function addDay(Request $request, ExercisePlan $plan)
    {
        // Check if the plan belongs to the user
        if ($plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_rest_day' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $dayNumber = $plan->days()->max('day_number') + 1 ?? 1;

        $validated['day_number'] = $dayNumber;
        $validated['is_rest_day'] = $request->has('is_rest_day');
        $validated['exercise_plan_id'] = $plan->id;

        ExercisePlanDay::create($validated);

        return redirect()->route('exercise-plans.edit', $plan)
            ->with('success', 'Workout day added successfully!');
    }

    public function updateDay(Request $request, ExercisePlanDay $day)
    {
        // Check if the plan belongs to the user
        if ($day->plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_rest_day' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_rest_day'] = $request->has('is_rest_day');

        $day->update($validated);

        return redirect()->route('exercise-plans.edit', $day->plan)
            ->with('success', 'Workout day updated successfully!');
    }

    public function deleteDay(ExercisePlanDay $day)
    {
        // Check if the plan belongs to the user
        if ($day->plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $plan = $day->plan;

        $day->delete();

        // Reorder the remaining days
        $plan->days()->orderBy('day_number')->get()->each(function ($day, $index) {
            $day->update(['day_number' => $index + 1]);
        });

        return redirect()->route('exercise-plans.edit', $plan)
            ->with('success', 'Workout day deleted successfully!');
    }

    public function addExercise(Request $request, ExercisePlanDay $day)
    {
        // Check if the plan belongs to the user
        if ($day->plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'duration' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $order = $day->exercises()->max('order') + 1 ?? 1;
        $validated['order'] = $order;
        $validated['exercise_plan_day_id'] = $day->id;

        ExercisePlanItem::create($validated);

        return redirect()->route('exercise-plans.edit', $day->plan)
            ->with('success', 'Exercise added successfully!');
    }

    public function updateExercise(Request $request, ExercisePlanItem $item)
    {
        // Check if the plan belongs to the user
        if ($item->day->plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $validated = $request->validate([
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'duration' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('exercise-plans.edit', $item->day->plan)
            ->with('success', 'Exercise updated successfully!');
    }

    public function deleteExercise(ExercisePlanItem $item)
    {
        // Check if the plan belongs to the user
        if ($item->day->plan->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this plan');
        }

        $plan = $item->day->plan;

        $item->delete();

        // Reorder the remaining exercises
        $item->day->exercises()->orderBy('order')->get()->each(function ($exercise, $index) {
            $exercise->update(['order' => $index + 1]);
        });

        return redirect()->route('exercise-plans.edit', $plan)
            ->with('success', 'Exercise removed successfully!');
    }
}
