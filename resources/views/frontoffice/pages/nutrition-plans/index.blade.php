@extends('layouts.app', ['activePage' => 'nutrition-plans'])

@section('title', 'Nutrition Plans - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    <span class="gradient-text">Nutrition Plans</span> for Your Fitness Goals
                </h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Browse custom nutrition plans or create your own to support your fitness journey.
                </p>
                <div class="mt-6">
                    <a href="{{ route('nutrition-plans.create') }}" class="btn-primary py-2 px-6 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-plus mr-2"></i> Create New Plan
                    </a>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="max-w-3xl mx-auto mb-10">
                <form method="GET" action="{{ route('nutrition-plans.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Search plans..." value="{{ request('search') }}"
                           class="w-full bg-slate-800 border border-slate-700 rounded-l-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-r-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($nutritionPlans as $plan)
                    <div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                        <div class="p-5">
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $plan->name }}</h3>
                            <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $plan->description ?? 'No description provided.' }}</p>

                            <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-calendar-day mr-2"></i>{{ $plan->duration_days }} days
                            </span>
                                <span class="text-gray-400 flex items-center">
                                <i class="fas fa-fire mr-2"></i>{{ $plan->daily_average_calories ?? 'N/A' }} cal/day
                            </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <img src="{{ $plan->user->profile_photo_url }}" alt="{{ $plan->user->name }}" class="h-8 w-8 rounded-full mr-2">
                                    <span class="text-sm text-gray-400">
                                    {{ $plan->user_id === auth()->id() ? 'You' : $plan->user->name }}
                                </span>
                                </div>

                                <a href="{{ route('nutrition-plans.show', $plan) }}" class="text-blue-400 hover:underline flex items-center">
                                    View Plan <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-slate-800/50 rounded-lg p-8 max-w-xl mx-auto">
                            <div class="w-16 h-16 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-utensils text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No nutrition plans found</h3>
                            <p class="text-gray-400 mb-6">
                                {{ request('search') ? 'Try different search terms or create your first nutrition plan.' : 'Create your first nutrition plan to get started!' }}
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $nutritionPlans->links('pagination::tailwind') }}
            </div>
        </div>
    </section>
@endsection
