@extends('layouts.app', ['activePage' => 'nutrition-plans'])

@section('title', 'My Nutrition Plans - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">My Nutrition Plans</h1>
                    <p class="text-gray-400">Create and manage your personalized meal plans</p>
                </div>
                <a href="{{ route('nutrition-plans.create') }}" class="btn-primary py-2 px-6 rounded-full text-white flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create New Plan
                </a>
            </div>

            <!-- Search Bar -->
            <div class="max-w-3xl mb-10">
                <form method="GET" action="{{ route('nutrition-plans.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Search plans..." value="{{ request('search') }}"
                           class="w-full bg-slate-800 border border-slate-700 rounded-l-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-r-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- User's Plans -->
            @if($myPlans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                    @foreach($myPlans as $plan)
                        <div class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-blue-500/30 transition duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                                    <span class="px-3 py-1 rounded-full text-xs {{ $plan->is_public ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                        {{ $plan->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </div>

                                <p class="text-gray-400 mb-6 line-clamp-2">{{ $plan->description ?: 'No description provided' }}</p>

                                <div class="flex items-center mb-6">
                                    <div class="flex items-center mr-6">
                                        <i class="fas fa-calendar-alt text-blue-400 mr-2"></i>
                                        <span class="text-gray-300">{{ $plan->duration_days }} days</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-fire text-blue-400 mr-2"></i>
                                        <span class="text-gray-300">{{ $plan->daily_average_calories ?? 'N/A' }} cal/day</span>
                                    </div>
                                </div>

                                <div class="flex space-x-3">
                                    <a href="{{ route('nutrition-plans.show', $plan) }}" class="flex-1 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-2 rounded-lg text-center transition">
                                        <i class="fas fa-eye mr-2"></i> View
                                    </a>
                                    <a href="{{ route('nutrition-plans.edit', $plan) }}" class="flex-1 bg-white/10 hover:bg-white/20 text-white py-2 rounded-lg text-center transition">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    <button
                                            onclick="confirmDelete('{{ $plan->id }}', '{{ $plan->name }}')"
                                            class="flex-1 bg-red-500/20 hover:bg-red-500/30 text-red-400 py-2 rounded-lg text-center transition">
                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                    </button>

                                    <form id="delete-form-{{ $plan->id }}" action="{{ route('nutrition-plans.destroy', $plan) }}" method="post" class="hidden">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-800/50 rounded-lg p-8 text-center mb-16">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-500/20 text-blue-400 rounded-full">
                        <i class="fas fa-utensils text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No Nutrition Plans Yet</h3>
                    <p class="text-gray-400 mb-6">Create your first nutrition plan to get started!</p>
                    <a href="{{ route('nutrition-plans.create') }}" class="btn-primary py-3 px-8 rounded-full text-white inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create New Plan
                    </a>
                </div>
            @endif

            <!-- Community Plans -->
            @if($publicPlans->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Community Nutrition Plans</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($publicPlans as $plan)
                            <div class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-purple-500/30 transition duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                                        <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400">
                                            Public
                                        </span>
                                    </div>

                                    <p class="text-gray-400 mb-4 line-clamp-2">{{ $plan->description ?: 'No description provided' }}</p>

                                    <div class="flex items-center mb-2">
                                        <img src="{{ $plan->user->profile_photo_url }}"
                                             alt="{{ $plan->user->name }}"
                                             class="w-6 h-6 rounded-full mr-2">
                                        <span class="text-gray-300 text-sm">Created by {{ $plan->user->name }}</span>
                                    </div>

                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center mr-6">
                                            <i class="fas fa-calendar-alt text-purple-400 mr-2"></i>
                                            <span class="text-gray-300">{{ $plan->duration_days }} days</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-fire text-purple-400 mr-2"></i>
                                            <span class="text-gray-300">{{ $plan->daily_average_calories ?? 'N/A' }} cal/day</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('nutrition-plans.show', $plan) }}" class="w-full bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 py-2 rounded-lg text-center block transition">
                                        <i class="fas fa-eye mr-2"></i> View Plan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pagination - if needed -->
            @if($myPlans->hasPages() || $publicPlans->hasPages())
                <div class="mt-8">
                    @if($myPlans->hasPages())
                        <div class="mb-4">
                            {{ $myPlans->links('pagination::tailwind') }}
                        </div>
                    @endif

                    @if($publicPlans->hasPages())
                        <div>
                            {{ $publicPlans->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function confirmDelete(planId, planName) {
            if(confirm(`Are you sure to delete "${planName}"? This action cannot be undone`)) {
                document.getElementById(`delete-form-${planId}`).submit();
            }
        }
    </script>
@endsection
