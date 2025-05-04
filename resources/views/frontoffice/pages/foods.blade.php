@extends('layouts.app', ['activePage' => 'foods'])

@section('title', 'Foods - FitTrack')

@section('content')
    <!-- Page Header -->
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Discover <span class="gradient-text">Foods</span> for Your Nutrition Goals
                </h1>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Browse our extensive collection of foods with detailed nutritional information to make informed
                    dietary choices.
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
                    <input type="text" id="searchFood" placeholder="Search foods..."
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
                </div>

                <!-- Active Filters -->
                <div id="activeFilters" class="flex flex-wrap justify-center gap-2">
                    <!-- Filter pills will be added here -->
                </div>
            </div>
        </div>
    </section>

    <!-- Foods Grid -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($foods as $food)
                    <div
                        class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300 food-card"
                        data-name="{{ strtolower($food->name) }}"
                        data-description="{{ strtolower($food->description ?? '') }}"
                        data-category="{{ $food->category_id ?? '' }}"
                        data-brand="{{ strtolower($food->brand ?? '') }}">
                        <!-- Food Image -->
                        <div class="h-48 overflow-hidden">
                            <img
                                src="{{ $food->image_url ?? 'https://images.unsplash.com/photo-1592545287571-8afd34aada57?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                                alt="{{ $food->name }}"
                                class="w-full h-full object-cover transition duration-300 transform hover:scale-105">
                        </div>
                        <!-- Food Content -->
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $food->name }}</h3>
                            <p class="text-gray-400 text-sm mb-3">{{ $food->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 flex items-center">
                                    <i class="fas fa-utensils mr-2"></i>{{ $food->portion_default }}
                                </span>
                                <a href="{{ route('foods.show', $food) }}"
                                   class="text-blue-400 hover:underline flex items-center">
                                    Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p id="noResultsMessage" class="text-center text-gray-400 py-8 hidden">No foods found matching your
                criteria.</p>
        </div>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/member/foods.js')
@endsection
