@extends('layouts.app', ['activePage' => 'foods'])

@section('title', $food->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Food Image -->
                <div>
                    <img src="{{ $food->image_url ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                         alt="{{ $food->name }}"
                         class="w-full rounded-lg shadow-lg">
                </div>

                <!-- Food Details -->
                <div>
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $food->name }}</h1>
                    <p class="text-gray-400 mb-6">{{ $food->description }}</p>

                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-utensils text-blue-400 mr-3"></i>
                            <span class="text-gray-300">Portion: {{ $food->portion_default }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-seedling text-green-400 mr-3"></i>
                            <span class="text-gray-300">Category: {{ $food->category->name ?? 'N/A' }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-apple-alt text-yellow-400 mr-3"></i>
                            <span class="text-gray-300">Brand: {{ $food->brand ?? 'N/A' }}</span>
                        </li>
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
                                    <span class="text-gray-300">Carbs: {{ $food->carbs ?? 0 }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                                    <span class="text-gray-300">Protein: {{ $food->protein ?? 0 }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                                    <span class="text-gray-300">Fat: {{ $food->fat ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-white mb-4">Nutritional Information</h3>
                        <div class="bg-slate-800 p-6 rounded-lg">
                            @foreach ($food->nutrients as $key => $value)
                                <div class="flex justify-between text-gray-300 mb-2">
                                    <span>{{ ucfirst($key) }}</span>
                                    <span>{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/charts/foodMacroChart.js')
    <script>
        window.foodNutrients = @json($food->nutrients);
    </script>
@endsection
