@extends('layouts.app', ['activePage' => 'exercise-plans'])

@section('title', 'Create Exercise Plan - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center mb-8">
                    <a href="{{ route('exercise-plans.index') }}" class="text-gray-400 hover:text-white transition mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-white">Create New Exercise Plan</h1>
                </div>

                <div class="bg-slate-800 rounded-xl p-8 mb-8">
                    <form action="{{ route('exercise-plans.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-gray-300 mb-2">Plan Name</label>
                            <input type="text" id="name" name="name"
                                   class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                   placeholder="E.g., 12-Week Strength Training" required>
                            @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-gray-300 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                      placeholder="Describe your workout plan and its goals"></textarea>
                            @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="level" class="block text-gray-300 mb-2">Difficulty Level</label>
                                <select id="level" name="level"
                                        class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                                @error('level')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration_weeks" class="block text-gray-300 mb-2">Duration (Weeks)</label>
                                <input type="number" id="duration_weeks" name="duration_weeks" min="1" max="52" value="4"
                                       class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                @error('duration_weeks')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" class="form-checkbox bg-slate-700 border-slate-600 rounded text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-gray-300">Make this plan public (share with community)</span>
                            </label>
                            @error('is_public')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary py-3 px-8 rounded-lg text-white font-medium inline-flex items-center">
                                Create Plan <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
