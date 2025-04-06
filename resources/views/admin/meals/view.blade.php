@extends('layouts.admin')

@section('title', $meal->name)

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Meal Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-5 flex items-center">
                @if($meal->image_url)
                    <img src="{{ $meal->image_url }}" alt="{{ $meal->name }}" class="h-16 w-16 object-cover rounded-full mr-4">
                @else
                    <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                        <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                @endif

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $meal->name }}</h1>
                    <div class="mt-1 flex items-center">
                        @php
                            $typeColors = [
                                'breakfast' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'lunch' => 'bg-green-100 text-green-800 border-green-200',
                                'dinner' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'snack' => 'bg-blue-100 text-blue-800 border-blue-200',
                            ];
                            $typeColor = $typeColors[$meal->type] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $typeColor }}">
                        {{ ucfirst($meal->type) }}
                    </span>
                        <span class="ml-2 text-sm text-gray-500">{{ $meal->items->count() }} items</span>
                    </div>
                </div>

                <div class="ml-auto">
                    <button type="button" onclick="openEditMealModal({{ $meal->id }})" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                        <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit
                    </button>
                    <button type="button" onclick="confirmDeleteMeal({{ $meal->id }}, '{{ $meal->name }}')" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Macronutrient Chart & Stats -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <!-- Chart -->
                <div class="p-6 flex justify-center items-center">
                    <div style="width: 200px; height: 200px;">
                        <canvas
                            id="macronutrientChart"
                            data-protein="{{ $meal->total_protein }}"
                            data-carbs="{{ $meal->total_carbs }}"
                            data-fat="{{ $meal->total_fat }}"
                        ></canvas>
                    </div>
                </div>

                <!-- Key nutrients -->
                <div class="md:col-span-2 p-6 grid grid-cols-3 gap-4">
                    <!-- Calories -->
                    <div class="bg-orange-50 rounded-lg p-4 text-center border border-orange-200">
                        <div class="text-orange-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">{{ round($meal->total_calories) }}</div>
                        <div class="text-sm text-gray-600 font-medium">Calories</div>
                    </div>

                    <!-- Protein -->
                    <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                        <div class="text-blue-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">{{ round($meal->total_protein, 1) }}g</div>
                        <div class="text-sm text-gray-600 font-medium">Protein</div>
                    </div>

                    <!-- Carbs -->
                    <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                        <div class="text-green-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">{{ round($meal->total_carbs, 1) }}g</div>
                        <div class="text-sm text-gray-600 font-medium">Carbs</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meal Description -->
        @if($meal->description)
            <div class="bg-white shadow rounded-lg mb-6 p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Description</h2>
                <p class="text-gray-700">{{ $meal->description }}</p>
            </div>
        @endif

        <!-- Meal Items (Foods) -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Food Items</h2>
            </div>

            <ul class="divide-y divide-gray-200">
                @foreach($meal->items as $item)
                    <li class="px-6 py-4">
                        <div class="flex items-center">
                            @if($item->food->image_url)
                                <img src="{{ $item->food->image_url }}" alt="{{ $item->food->name }}" class="h-12 w-12 object-cover rounded-full">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                </div>
                            @endif

                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->food->name }}</h3>
                                    <span class="text-sm font-medium text-gray-900">{{ $item->nutrients['calories'] ?? 0 }} calories</span>
                                </div>
                                <div class="mt-1 flex justify-between">
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} {{ $item->quantity_unit }}</p>
                                    <div class="text-sm text-gray-500">
                                        <span class="mr-2">P: {{ round($item->nutrients['protein_g'] ?? 0, 1) }}g</span>
                                        <span class="mr-2">C: {{ round($item->nutrients['carbs_g'] ?? 0, 1) }}g</span>
                                        <span>F: {{ round($item->nutrients['fat_g'] ?? 0, 1) }}g</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Related Meals -->
        @if(count($relatedMeals) > 0)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Related {{ ucfirst($meal->type) }} Meals</h2>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($relatedMeals as $relatedMeal)
                        <a href="{{ route('admin.meals.show', $relatedMeal->id) }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                            @if($relatedMeal->image_url)
                                <img src="{{ $relatedMeal->image_url }}" alt="{{ $relatedMeal->name }}" class="h-10 w-10 object-cover rounded-full">
                            @else
                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $relatedMeal->name }}</p>
                                <p class="text-xs text-gray-500">{{ $relatedMeal->items->count() }} items</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Edit Meal Modal -->
    <x-modal id="editMealModal" title="Edit Meal" iconType="edit" maxWidth="2xl">
        <!-- Same content as in index.blade.php -->
    </x-modal>

    <!-- Delete Meal Modal -->
    <x-modal id="deleteMealModal" title="Delete Meal" iconType="delete" maxWidth="md">
        <!-- Same content as in index.blade.php -->
    </x-modal>

    <!-- Food Search Modal -->
    <x-modal id="foodSearchModal" title="Select a Food Item" iconType="create" maxWidth="lg">
        <!-- Same content as in index.blade.php -->
    </x-modal>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/meals.js') }}"></script>
@endsection
