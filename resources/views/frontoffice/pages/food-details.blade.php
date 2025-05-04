@extends('layouts.app', ['activePage' => 'exercise-plans'])

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
                                    <span class="text-gray-300">Carbs</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                                    <span class="text-gray-300">Protein</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                                    <span class="text-gray-300">Fat</span>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Extract macronutrient values from nutrients json
            const nutrients = @json($food->nutrients);

            // Get values for the three main macronutrients
            const carbs = parseFloat(nutrients.carbohydrates || nutrients.carbs || 0);
            const protein = parseFloat(nutrients.protein || 0);
            const fat = parseFloat(nutrients.fat || nutrients.fats || 0);

            // Calculate calories from each macronutrient
            const carbsCal = carbs * 4;  // 4 calories per gram of carbs
            const proteinCal = protein * 4;  // 4 calories per gram of protein
            const fatCal = fat * 9;  // 9 calories per gram of fat

            // Total calories from macros
            const totalCal = carbsCal + proteinCal + fatCal;

            // Create the pie chart
            const ctx = document.getElementById('macroChart').getContext('2d');
            const macroChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Carbs', 'Protein', 'Fat'],
                    datasets: [{
                        data: [carbs, protein, fat],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',  // Blue for carbs
                            'rgba(16, 185, 129, 0.8)',  // Green for protein
                            'rgba(234, 179, 8, 0.8)'    // Yellow for fat
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(234, 179, 8, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false  // We'll use our custom legend below the chart
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value}g (${percentage}%)`;
                                }
                            },
                            backgroundColor: 'rgba(17, 24, 39, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#374151',
                            borderWidth: 1
                        }
                    }
                }
            });
        });
    </script>
@endsection
