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
                    Find exercises tailored to your workout routine, categorized by muscle group, difficulty, and
                    equipment.
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
                    <input type="text" id="searchExercise" placeholder="Search exercises..."
                           class="w-full bg-slate-900 text-white border border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Filter Pills -->
                <div class="flex flex-wrap justify-center gap-3">
                    <!-- Type Filter -->
                    <div class="relative group">
                        <select name="type"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Types</option>
                            <option value="strength">Strength</option>
                            <option value="cardio">Cardio</option>
                            <option value="flexibility">Flexibility</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Muscle Group Filter -->
                    <div class="relative group">
                        <select name="muscle_group"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Muscle Groups</option>
                            <option value="chest">Chest</option>
                            <option value="legs">Legs</option>
                            <option value="back">Back</option>
                            <option value="shoulders">Shoulders</option>
                            <option value="arms">Arms</option>
                            <option value="core">Core</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Difficulty Filter -->
                    <div class="relative group">
                        <select name="difficulty"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Difficulties</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Equipment Filter -->
                    <div class="relative group">
                        <select name="equipment"
                                class="filter-select appearance-none bg-slate-900 text-white border border-slate-700 rounded-full px-5 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                            <option value="">All Equipment</option>
                            <option value="none">Bodyweight</option>
                            <option value="dumbbells">Dumbbells</option>
                            <option value="barbells">Barbells</option>
                            <option value="machines">Machines</option>
                            <option value="bands">Resistance Bands</option>
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

    <!-- Exercise Cards -->
    <section class="py-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($exercises as $exercise)
                    <div
                        class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300"
                        data-name="{{ strtolower($exercise->name) }}"
                        data-description="{{ strtolower($exercise->description) }}"
                        data-type="{{ strtolower($exercise->type) }}"
                        data-equipment="{{ strtolower($exercise->equipment) }}"
                        data-muscle="{{ strtolower($exercise->target_muscle) }}"
                        data-difficulty="{{ strtolower($exercise->difficulty) }}">
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
                                <a href="{{ route('exercises.show', $exercise) }}"
                                   class="text-blue-400 hover:underline flex items-center">
                                    Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No results message will be inserted here by JavaScript -->
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/exercises.js') }}"></script>
@endsection
