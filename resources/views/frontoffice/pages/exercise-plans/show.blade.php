@extends('layouts.app')

@section('title', $plan->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Plan Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                    <div class="flex items-center mb-4 md:mb-0">
                        <a href="{{ route('exercise-plans.index') }}" class="text-gray-400 hover:text-white transition mr-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="text-3xl font-bold text-white">{{ $plan->name }}</h1>
                    </div>

                    @if($plan->user_id === auth()->id())
                        <a href="{{ route('exercise-plans.edit', $plan) }}" class="btn-primary py-2 px-6 rounded-full text-white inline-flex items-center self-start md:self-center">
                            <i class="fas fa-edit mr-2"></i> Edit Plan
                        </a>
                    @endif
                </div>

                <!-- Plan Info -->
                <div class="bg-slate-800 rounded-xl overflow-hidden mb-12">
                    <div class="p-8">
                        <div class="flex flex-wrap gap-4 mb-6">
                        <span class="px-4 py-2 rounded-full text-sm font-medium {{ $plan->level_badge }}">
                            {{ ucfirst($plan->level) }}
                        </span>

                            <span class="px-4 py-2 rounded-full bg-blue-500/20 text-blue-400 text-sm font-medium">
                            {{ $plan->duration_weeks }} {{ Str::plural('Week', $plan->duration_weeks) }}
                        </span>

                            <span class="px-4 py-2 rounded-full bg-purple-500/20 text-purple-400 text-sm font-medium">
                            {{ $plan->days->count() }} {{ Str::plural('Day', $plan->days->count()) }}
                        </span>

                            @if($plan->is_public)
                                <span class="px-4 py-2 rounded-full bg-green-500/20 text-green-400 text-sm font-medium">
                                <i class="fas fa-users mr-1"></i> Public Plan
                            </span>
                            @endif
                        </div>

                        <div class="flex items-center mb-6">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($plan->user->name) }}&background=random"
                                 alt="User avatar"
                                 class="w-8 h-8 rounded-full mr-3">
                            <span class="text-gray-300">Created by {{ $plan->user->name }}</span>
                        </div>

                        @if($plan->description)
                            <div class="bg-slate-700/30 p-4 rounded-lg mb-6">
                                <p class="text-gray-300">{{ $plan->description }}</p>
                            </div>
                        @endif

                        <div class="bg-blue-500/10 text-blue-400 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2"><i class="fas fa-info-circle mr-2"></i> Plan Overview</h3>
                            <p>This {{ Str::lower($plan->level) }} level plan runs for {{ $plan->duration_weeks }} {{ Str::plural('week', $plan->duration_weeks) }} with {{ $plan->days->count() }} workout days.
                                @if($plan->days->where('is_rest_day', true)->count() > 0)
                                    Includes {{ $plan->days->where('is_rest_day', true)->count() }} rest {{ Str::plural('day', $plan->days->where('is_rest_day', true)->count()) }}.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Day Navigation -->
                <div class="bg-slate-800 rounded-xl p-6 mb-8 overflow-x-auto">
                    <div class="flex space-x-2 min-w-max">
                        @foreach($plan->days as $day)
                            <a href="#day-{{ $day->id }}"
                               class="px-4 py-2 rounded-full {{ $day->is_rest_day ? 'bg-green-500/20 text-green-400' : 'bg-white/10 text-white hover:bg-white/20' }} text-sm font-medium transition">
                                Day {{ $day->day_number }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Workout Days -->
                <div class="space-y-8">
                    @foreach($plan->days as $day)
                        <div id="day-{{ $day->id }}" class="bg-slate-800 rounded-xl overflow-hidden">
                            <div class="bg-slate-700 p-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                    <span class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold mr-4">
                                        {{ $day->day_number }}
                                    </span>
                                        <h2 class="text-2xl font-bold text-white">{{ $day->name }}</h2>
                                        @if($day->is_rest_day)
                                            <span class="ml-4 px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                            Rest Day
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                @if($day->notes)
                                    <div class="bg-slate-700/30 p-4 rounded-lg mb-6">
                                        <h3 class="text-lg font-semibold text-white mb-2">Notes:</h3>
                                        <p class="text-gray-300">{{ $day->notes }}</p>
                                    </div>
                                @endif

                                @if(!$day->is_rest_day)
                                    <h3 class="text-xl font-semibold text-white mb-4">Exercises</h3>

                                    <div class="space-y-4">
                                        @forelse($day->exercises as $item)
                                            <div class="bg-slate-700/50 p-4 rounded-lg">
                                                <div class="flex justify-between">
                                                    <div class="flex">
                                                    <span class="bg-blue-500/20 text-blue-400 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                        <div>
                                                            <h4 class="font-semibold text-white">{{ $item->exercise->name }}</h4>
                                                            <div class="text-gray-400 mt-1">
                                                                @if($item->sets && $item->reps)
                                                                    <span class="inline-flex items-center bg-slate-700 px-3 py-1 rounded-full text-sm mr-2">
                                                                    <i class="fas fa-layer-group text-blue-400 mr-2"></i> {{ $item->sets }} sets
                                                                </span>
                                                                    <span class="inline-flex items-center bg-slate-700 px-3 py-1 rounded-full text-sm mr-2">
                                                                    <i class="fas fa-redo text-green-400 mr-2"></i> {{ $item->reps }} reps
                                                                </span>
                                                                @elseif($item->duration)
                                                                    <span class="inline-flex items-center bg-slate-700 px-3 py-1 rounded-full text-sm mr-2">
                                                                                                                                    <i class="fas fa-clock text-yellow-400 mr-2"></i> {{ $item->duration }}
                                                                </span>
                                                                @endif

                                                                @if($item->exercise->target_muscle)
                                                                    <span class="inline-flex items-center bg-slate-700 px-3 py-1 rounded-full text-sm">
                                                                    <i class="fas fa-bullseye text-red-400 mr-2"></i> {{ $item->exercise->target_muscle }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('exercises.show', $item->exercise) }}" class="self-start bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-1 px-3 rounded-full text-xs transition">
                                                        View Details
                                                    </a>
                                                </div>
                                                @if($item->notes)
                                                    <div class="mt-3 ml-11 bg-slate-700/80 p-3 rounded-md text-gray-300 text-sm">
                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item->notes }}
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="bg-slate-700/30 p-4 rounded-lg text-center">
                                                <p class="text-gray-400">No exercises have been added to this day.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    @else
                                        <div class="bg-green-500/10 text-green-400 p-6 rounded-lg text-center">
                                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-500/20 rounded-full">
                                                <i class="fas fa-bed text-2xl"></i>
                                            </div>
                                            <h3 class="text-xl font-semibold mb-2">Rest Day</h3>
                                            <p>Take time to recover and let your muscles rebuild.</p>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center mt-12">
                    <a href="{{ route('exercise-plans.index') }}" class="bg-white/10 hover:bg-white/20 py-3 px-6 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Plans
                    </a>

                    @if($plan->user_id === auth()->id())
                        <a href="{{ route('exercise-plans.edit', $plan) }}" class="btn-primary py-3 px-6 rounded-lg text-white inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit This Plan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#day-"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
