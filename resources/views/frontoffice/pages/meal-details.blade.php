@extends('layouts.app', ['activePage' => 'meals'])

@section('title', $meal->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Meal Image -->
                <div>
                    <img src="{{ $meal->image_url ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                         alt="{{ $meal->name }}"
                         class="w-full rounded-lg shadow-lg">
                </div>

                <!-- Meal Details -->
                <div>
                    <div class="mb-4">
                        <a href="{{ route('meals.index') }}"
                           class="text-blue-400 hover:text-blue-300 flex items-center w-fit">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Meals
                        </a>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-4">{{ $meal->name }}</h1>
                    <p class="text-gray-400 mb-6">{{ $meal->description }}</p>

                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-fire text-orange-400 mr-3"></i>
                            <span class="text-gray-300">Calories: {{ $meal->totalCalories ?? 'N/A' }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-blue-400 mr-3"></i>
                            <span class="text-gray-300">Prep Time: {{ $meal->preparation_time ?? 'N/A' }} mins</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-utensils text-green-400 mr-3"></i>
                            <span class="text-gray-300">Servings: {{ $meal->servings ?? 'N/A' }}</span>
                        </li>
                        @if($meal->category)
                            <li class="flex items-center">
                                <i class="fas fa-tag text-purple-400 mr-3"></i>
                                <span class="text-gray-300">Category: {{ $meal->category->name ?? 'N/A' }}</span>
                            </li>
                        @endif
                    </ul>

                    <!-- Macronutrient Pie Chart -->
                    <div class="mt-8 mb-8">
                        <h3 class="text-xl font-semibold text-white mb-4">Macronutrient Breakdown</h3>
                        <div class="bg-slate-800 p-6 rounded-lg">
                            <div class="h-64">
                                <canvas id="macroChart"></canvas>
                            </div>

                            <!-- Macronutrient Legend -->
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-gray-300">Protein: {{ $meal->totalProtein ?? '0' }}g</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                                    <span class="text-gray-300">Carbs: {{ $meal->totalCarbs ?? '0' }}g</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-gray-300">Fat: {{ $meal->totalFat ?? '0' }}g</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ingredients Summary (if available) -->
                    @if(isset($meal->foods) && count($meal->foods) > 0)
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-white mb-4">Main Ingredients</h3>
                            <div class="bg-slate-800 p-6 rounded-lg">
                                <ul class="space-y-2">
                                    @foreach($meal->foods as $food)
                                        <li class="flex justify-between text-gray-300">
                                            <span>{{ $food->name }}</span>
                                            <span>{{ $food->pivot->quantity ?? '1' }} {{ $food->pivot->quantity_unit ?? 'serving' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/charts/mealStatsChart.js')
    <script>
        window.mealProtein = {{ $meal->totalProtein ?? 0 }};
        window.mealCarbs = {{ $meal->totalCarbs ?? 0 }};
        window.mealFat = {{ $meal->totalFat ?? 0 }};
    </script>
@endsection
