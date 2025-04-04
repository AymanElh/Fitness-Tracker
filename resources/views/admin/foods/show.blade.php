@extends('layouts.admin')

@section('title', $food->name . ' | Food Details')

@section('styles')
    <style>
        .nutrient-card {
            transition: all 0.3s ease;
        }
        .nutrient-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .chart-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        @media (max-width: 640px) {
            .chart-container {
                width: 150px;
                height: 150px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 text-sm font-medium">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('admin.foods.index') }}" class="ml-1 text-gray-700 hover:text-indigo-600 text-sm font-medium md:ml-2">
                                Food Items
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 text-sm font-medium">
                            {{ $food->name }}
                        </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Food Header -->
        <div class="bg-white shadow rounded-lg mb-6 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-center">
                    @if($food->image_url)
                        <div class="flex-shrink-0 h-16 w-16 rounded-full overflow-hidden mr-4">
                            <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>
                    @endif

                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $food->name }}</h1>
                        <div class="mt-1 flex items-center">
                            @if($food->category)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                      style="background-color: {{ hex_to_rgba($food->category->color_code ?? '#6B7280', 0.1) }}; color: {{ $food->category->color_code ?? '#6B7280' }};">
                                {{ $food->category->name }}
                            </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Uncategorized
                            </span>
                            @endif
                            <span class="ml-2 text-sm text-gray-500">ID: {{ $food->id }}</span>
                        </div>
                    </div>
                </div>

{{--                <div class="mt-4 md:mt-0 flex">--}}
{{--                    <a href="" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">--}}
{{--                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>--}}
{{--                        </svg>--}}
{{--                        Edit--}}
{{--                    </a>--}}
{{--                    <button type="button" onclick="confirmDeleteFood({{ $food->id }}, '{{ $food->name }}')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">--}}
{{--                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>--}}
{{--                        </svg>--}}
{{--                        Delete--}}
{{--                    </button>--}}
                </div>
            </div>

            <!-- Macronutrient Chart -->
            <div class="p-6 bg-gray-50">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Macronutrient Distribution</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Chart -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="chart-container">
                                <canvas id="macronutrientChart"></canvas>
                            </div>
                        </div>

                        <!-- Key Nutrients -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Calories Card -->
                            <div class="nutrient-card bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 shadow text-center border border-orange-200">
                                <div class="text-orange-500 mb-2">
                                    <svg class="h-8 w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-gray-800">{{ $food->nutrients['calories'] ?? 0 }}</div>
                                <div class="text-sm text-gray-600 font-medium">Calories</div>
                                <div class="text-xs text-gray-500 mt-1">per {{ $food->portion_default }}</div>
                            </div>

                            <!-- Protein Card -->
                            <div class="nutrient-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 shadow text-center border border-blue-200">
                                <div class="text-blue-500 mb-2">
                                    <svg class="h-8 w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-gray-800">{{ $food->nutrients['protein_g'] ?? 0 }}g</div>
                                <div class="text-sm text-gray-600 font-medium">Protein</div>
                                <div class="text-xs text-gray-500 mt-1">{{ proteinCalories($food->nutrients['protein_g'] ?? 0) }} calories</div>
                            </div>

                            <!-- Carbs Card -->
                            <div class="nutrient-card bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 shadow text-center border border-green-200">
                                <div class="text-green-500 mb-2">
                                    <svg class="h-8 w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-gray-800">{{ $food->nutrients['carbs_g'] ?? 0 }}g</div>
                                <div class="text-sm text-gray-600 font-medium">Carbohydrates</div>
                                <div class="text-xs text-gray-500 mt-1">{{ carbsCalories($food->nutrients['carbs_g'] ?? 0) }} calories</div>
                            </div>

                            <!-- Fat Card -->
                            <div class="nutrient-card bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 shadow text-center border border-yellow-200">
                                <div class="text-yellow-500 mb-2">
                                    <svg class="h-8 w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-gray-800">{{ $food->nutrients['fat_g'] ?? 0 }}g</div>
                                <div class="text-sm text-gray-600 font-medium">Fat</div>
                                <div class="text-xs text-gray-500 mt-1">{{ fatCalories($food->nutrients['fat_g'] ?? 0) }} calories</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Nutrient Information -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Nutrient Information</h2>
                <p class="mt-1 text-sm text-gray-500">Detailed information about this food's nutrients.</p>
            </div>

            <div class="p-6">
                <div class="overflow-hidden sm:rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nutrient
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Percent Daily Value*
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Calories -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Calories
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['calories'] ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ caloriesDailyValue($food->nutrients['calories'] ?? 0) }}%
                            </td>
                        </tr>

                        <!-- Total Fat -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Total Fat
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['fat_g'] ?? 0 }}g
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ fatDailyValue($food->nutrients['fat_g'] ?? 0) }}%
                            </td>
                        </tr>

                        <!-- Total Carbohydrates -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Total Carbohydrates
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['carbs_g'] ?? 0 }}g
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ carbsDailyValue($food->nutrients['carbs_g'] ?? 0) }}%
                            </td>
                        </tr>

                        <!-- Dietary Fiber -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 pl-10">
                                Dietary Fiber
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['fiber_g'] ?? 0 }}g
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ fiberDailyValue($food->nutrients['fiber_g'] ?? 0) }}%
                            </td>
                        </tr>

                        <!-- Sugars -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 pl-10">
                                Sugars
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['sugar_g'] ?? 0 }}g
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                -
                            </td>
                        </tr>

                        <!-- Protein -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Protein
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $food->nutrients['protein_g'] ?? 0 }}g
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ proteinDailyValue($food->nutrients['protein_g'] ?? 0) }}%
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p class="mt-3 text-xs text-gray-500">* Percent Daily Values are based on a 2,000 calorie diet.</p>
            </div>
        </div>

        <!-- Food Details -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Additional Information</h2>
            </div>

            <div class="p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 md:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Serving Size</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $food->portion_default }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $food->category ? $food->category->name : 'Uncategorized' }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $food->creator ? $food->creator->name : 'System' }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $food->created_at->format('Y-m-d H:i:s') }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $food->description ?: 'No description available.' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Related Food Items -->
        @if(count($relatedFoods) > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Related Food Items</h2>
                    <p class="mt-1 text-sm text-gray-500">Other food items in the same category.</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($relatedFoods as $relatedFood)
                            <a href="{{ route('admin.foods.show', $relatedFood->id) }}" class="relative rounded-lg border border-gray-200 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-indigo-500 focus:outline-none">
                                <div class="flex-shrink-0">
                                    @if($relatedFood->image_url)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $relatedFood->image_url }}" alt="{{ $relatedFood->name }}">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="focus:outline-none">
                                        <p class="text-sm font-medium text-gray-900">{{ $relatedFood->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $relatedFood->nutrients['calories'] ?? 0 }} calories</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Food Confirmation Modal -->
    <div id="deleteFoodModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Modal Implementation -->
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Food Item
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="delete-food-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteFoodForm" method="POST" action="" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteFoodModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            // Get data from backend
            const proteinG = {{ $food->nutrients['protein_g'] ?? 0 }};
            const carbsG = {{ $food->nutrients['carbs_g'] ?? 0 }};
            const fatG = {{ $food->nutrients['fat_g'] ?? 0 }};

            // Convert grams to calories
            const proteinCal = proteinG * 4;  // 4 calories per gram of protein
            const carbsCal = carbsG * 4;      // 4 calories per gram of carbs
            const fatCal = fatG * 9;          // 9 calories per gram of fat

            // Create chart
            const ctx = document.getElementById('macronutrientChart').getContext('2d');
            const macronutrientChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Protein', 'Carbs', 'Fat'],
                    datasets: [{
                        data: [proteinCal, carbsCal, fatCal],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // Blue for protein
                            'rgba(16, 185, 129, 0.8)', // Green for carbs
                            'rgba(245, 158, 11, 0.8)'  // Yellow for fat
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} cal (${percentage}%)`;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                boxWidth: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                    }
                }
            });
        });

        // Modal Functions
        function confirmDeleteFood(id, name) {
            document.getElementById('delete-food-text').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            document.getElementById('deleteFoodForm').action = `/admin/foods/${id}`;
            document.getElementById('deleteFoodModal').classList.remove('hidden');
        }

        function closeDeleteFoodModal() {
            document.getElementById('deleteFoodModal').classList.add('hidden');
        }
    </script>
@endsection
