@extends('layouts.app', ['activePage' => 'meals'])

@section('title', 'Meals - FitTrack')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Explore <span class="gradient-text">Meals</span> for Your Nutrition Goals
                </h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Browse pre-designed meal plans tailored to support your fitness journey.
                </p>
            </div>
        </div>
    </section>

    <!-- Search & Filters Section -->
    <section class="py-8 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <div class="space-y-6">
                <!-- Search Bar -->
                <div class="relative max-w-2xl mx-auto">
                    <input type="text" id="searchMeal" placeholder="Search meals..."
                           class="w-full bg-slate-900 text-white border border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Filter Pills -->
                <div class="flex flex-wrap justify-center gap-3">
                    <!-- Category Filter -->
                    <div class="relative group">
                        <select id="categoryFilter"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Meal Type Filter -->
                    <div class="relative group">
                        <select id="typeFilter"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Meal Types</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="snack">Snack</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                <div id="activeFilters" class="flex flex-wrap justify-center gap-2">
                    <!-- Filter pills will be added here -->
                </div>
            </div>
        </div>
    </section>

    <!-- Meals Grid -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            @if ($meals->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($meals as $meal)
                        <div
                            data-name="{{ strtolower($meal->name) }}"
                            data-description="{{ strtolower($meal->description ?? '') }}"
                            data-category="{{ $meal->category_id ?? '' }}"
                            data-type="{{ $meal->type }}"
                            class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                            <!-- Meal Image -->
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $meal->image_url ?? 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                     alt="{{ $meal->name }}"
                                     class="w-full h-full object-cover transition duration-300 transform hover:scale-105">
                            </div>
                            <!-- Meal Content -->
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $meal->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3">{{ $meal->description }}</p>
                                <div class="flex justify-between items-center">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-400 flex items-center">
                                            @switch($meal->type)
                                                @case('breakfast')
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs flex items-center">
                                                        <i class="fas fa-sun mr-1"></i> Breakfast
                                                    </span>
                                                    @break
                                                @case('lunch')
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs flex items-center">
                                                        <i class="fas fa-cloud-sun mr-1"></i> Lunch
                                                    </span>
                                                    @break
                                                @case('dinner')
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-purple-500/20 text-purple-400 text-xs flex items-center">
                                                        <i class="fas fa-moon mr-1"></i> Dinner
                                                    </span>
                                                    @break
                                                @case('snack')
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-green-500/20 text-green-400 text-xs flex items-center">
                                                        <i class="fas fa-cookie mr-1"></i> Snack
                                                    </span>
                                                    @break
                                                @default
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-gray-500/20 text-gray-400 text-xs flex items-center">
                                                        <i class="fas fa-utensils mr-1"></i> Meal
                                                    </span>
                                            @endswitch
                                        </span>
                                    </div>
                                    <a href="{{ route('meals.show', $meal) }}"
                                       class="text-blue-400 hover:underline flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p id="noResultsMessage" class="text-center text-gray-400 py-8 hidden">No meals found matching your
                    criteria.</p>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $meals->links('pagination::tailwind') }}
                </div>
            @else
                <p class="text-center text-gray-400">No meals found matching your criteria.</p>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/member/meals.js')

@endsection
