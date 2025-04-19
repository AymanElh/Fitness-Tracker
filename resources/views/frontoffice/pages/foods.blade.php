@extends('layouts.app')

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
                    Browse our extensive collection of foods with detailed nutritional information to make informed dietary choices.
                </p>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-8 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('foods.index') }}" class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4 justify-center">
                <!-- Category Filter -->
                <select name="category" class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Search Filter -->
                <input
                    type="text"
                    name="search"
                    placeholder="Search foods..."
                    value="{{ request('search') }}"
                    class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                    Filter
                </button>
            </form>
        </div>
    </section>

    <!-- Foods Grid -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            @if ($foods->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($foods as $food)
                        <div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                            <!-- Food Image -->
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $food->image_url ?? 'https://via.placeholder.com/400x300?text=No+Image' }}"
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
                                    <a href="{{ route('foods.show', $food) }}" class="text-blue-400 hover:underline flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $foods->links('pagination::tailwind') }}
                </div>
            @else
                <p class="text-center text-gray-400">No foods found matching your criteria.</p>
            @endif
        </div>
    </section>
@endsection
