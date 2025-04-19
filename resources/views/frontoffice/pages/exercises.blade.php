@extends('layouts.app')

@section('title', 'Exercises - FitTrack')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Explore <span class="gradient-text">Exercises</span> for Your Fitness Goals
                </h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Find exercises tailored to your workout routine, categorized by muscle group, difficulty, and equipment.
                </p>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-8 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('exercises.index') }}" class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4 justify-center">
                <!-- Type Filter -->
                <select name="type" class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="strength" {{ request('type') == 'strength' ? 'selected' : '' }}>Strength</option>
                    <option value="cardio" {{ request('type') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                    <option value="flexibility" {{ request('type') == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                </select>

                <!-- Muscle Group Filter -->
                <select name="muscle_group" class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Muscle Groups</option>
                    <option value="chest" {{ request('muscle_group') == 'chest' ? 'selected' : '' }}>Chest</option>
                    <option value="legs" {{ request('muscle_group') == 'legs' ? 'selected' : '' }}>Legs</option>
                    <option value="back" {{ request('muscle_group') == 'back' ? 'selected' : '' }}>Back</option>
                    <option value="shoulders" {{ request('muscle_group') == 'shoulders' ? 'selected' : '' }}>Shoulders</option>
                    <option value="arms" {{ request('muscle_group') == 'arms' ? 'selected' : '' }}>Arms</option>
                </select>

                <!-- Difficulty Filter -->
                <select name="difficulty" class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Difficulties</option>
                    <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>

                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                    Filter
                </button>
            </form>
        </div>
    </section>

    <!-- Exercises Grid -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            @if ($exercises->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($exercises as $exercise)
                        <div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                            <!-- Exercise Image -->
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $exercise->image_url ?? 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                     alt="{{ $exercise->name }}"
                                     class="w-full h-full object-cover transition duration-300 transform hover:scale-105">
                            </div>
                            <!-- Exercise Content -->
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $exercise->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3">{{ $exercise->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 flex items-center"><i class="fas fa-clock mr-2"></i>{{ $exercise->duration ?? 'N/A' }} mins</span>
                                    <a href="{{ route('exercises.show', $exercise) }}" class="text-blue-400 hover:underline flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $exercises->links('pagination::tailwind') }}
                </div>
            @else
                <p class="text-center text-gray-400">No exercises found matching your criteria.</p>
            @endif
        </div>
    </section>
@endsection
