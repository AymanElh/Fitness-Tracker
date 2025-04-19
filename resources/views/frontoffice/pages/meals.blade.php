@extends('layouts.app')

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

    <!-- Filters Section -->
    <section class="py-8 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('meals.index') }}" class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4 justify-center">
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
                    placeholder="Search meals..."
                    value="{{ request('search') }}"
                    class="bg-slate-900 text-white border border-slate-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                    Filter
                </button>
            </form>
        </div>
    </section>

    <!-- Meals Grid -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            @if ($meals->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($meals as $meal)
                        <div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
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
                                    <span class="text-gray-400 flex items-center">
                                        <i class="fas fa-clock mr-2"></i>{{ $meal->duration }} mins
                                    </span>
                                    <a href="{{ route('meals.show', $meal) }}" class="text-blue-400 hover:underline flex items-center">
                                        Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

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
