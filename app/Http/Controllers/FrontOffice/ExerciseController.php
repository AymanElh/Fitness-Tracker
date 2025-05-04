<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\Exercise;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the exercises.
     */
    public function index()
    {
        $exercises = Exercise::all();
        return view('frontoffice.pages.exercises', compact('exercises'));
    }

    /**
     * Display the specified exercise.
     */
    public function show(Exercise $exercise)
    {
        return view('frontoffice.pages.exercise-details', compact('exercise'));
    }
}
