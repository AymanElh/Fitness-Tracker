@extends('layouts.app')

@section('title', $exercise->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Exercise Image -->
                <div>
                    <img src="{{ $exercise->image_url ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                         alt="{{ $exercise->name }}"
                         class="w-full rounded-lg shadow-lg">
                </div>

                <!-- Exercise Details -->
                <div>
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $exercise->name }}</h1>
                    <p class="text-gray-400 mb-6">{{ $exercise->description }}</p>

                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-dumbbell text-blue-400 mr-3"></i>
                            <span class="text-gray-300">Type: {{ ucfirst($exercise->type) }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-user-circle text-green-400 mr-3"></i>
                            <span class="text-gray-300">Muscle Group: {{ ucfirst($exercise->muscle_group ?? 'N/A') }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-3"></i>
                            <span class="text-gray-300">Difficulty: {{ ucfirst($exercise->difficulty) }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-red-400 mr-3"></i>
                            <span class="text-gray-300">Duration: {{ $exercise->duration ?? 'N/A' }} mins</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-fire text-orange-400 mr-3"></i>
                            <span class="text-gray-300">Calories Burned: {{ $exercise->calories_burned ?? 'N/A' }} kcal</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-cogs text-purple-400 mr-3"></i>
                            <span class="text-gray-300">Equipment: {{ $exercise->equipment ?? 'N/A' }}</span>
                        </li>
                    </ul>

                    @if ($exercise->video_url)
                        <div class="mt-8">
                            <a href="{{ $exercise->video_url }}" target="_blank" class="btn-primary px-6 py-3 rounded-lg">
                                Watch Video <i class="fas fa-play ml-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
