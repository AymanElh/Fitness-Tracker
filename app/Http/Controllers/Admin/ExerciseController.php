<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditExerciseRequest;
use App\Http\Requests\StoreExerciseRequest;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::with('creator')->paginate(10);
        $totalExercises = Exercise::count();
        return view('admin.exercises.index', [
            'exercises' => $exercises,
            'totalExercises' => $totalExercises
        ]);
    }

    public function create()
    {
        $exerciseTypes = Exercise::getTypeOptions();
        $muscleGroups = Exercise::getMuscleGroupOptions();
        $difficultyLevels = Exercise::getDifficultyOptions();
        return view('admin.exercises.create', compact('exerciseTypes', 'muscleGroups', 'difficultyLevels'));
    }

    public function store(StoreExerciseRequest $request)
    {
        $validated = $request->validated();

        $validated['created_by'] = Auth::id();

        $exercise = Exercise::create($validated);
        return redirect()->route('admin.exercises.index')->with('success', 'Exercise Created Successfully');
    }

    public function edit(Exercise $exercise)
    {
        $exerciseTypes = Exercise::getTypeOptions();
        $muscleGroups = Exercise::getMuscleGroupOptions();
        $difficultyLevels = Exercise::getDifficultyOptions();
        return view('admin.exercises.edit', compact('exercise', 'exerciseTypes', 'muscleGroups', 'difficultyLevels'));
    }

    public function update(EditExerciseRequest $request, Exercise $exercise): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $exercise->update($validated);
        return redirect()->route('admin.exercises.index')->with('success', 'Exercise updated successfully');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('admin.exercises.index')->with('success', "Exercise Deleted successfully");
    }
}
