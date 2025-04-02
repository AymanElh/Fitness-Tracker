@extends('layouts.admin')

@section('title', 'Food Items Management')

@section('content')
    <div class="py-6">
        <div class="max-w-10~xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Food Items Management
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Last updated: {{ date('F j, Y, g:i a', strtotime('2025-04-01 10:50:35')) }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a6 6 0 0012 0c0-.35-.035-.69-.1-1.021A5 5 0 0010 11z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Updated by: AymanElh
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button type="button"
                            onclick="openCreateFoodModal()"
                            class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Add New Food Item
                    </button>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <x-alert type="success" id="successAlert">
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" id="errorAlert">
                    <p class="font-bold">Error!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="error" id="validationErrors">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                <!-- Total Foods Card -->
                <x-stat-card
                    title="Total Food Items"
                    value="{{ $totalFoods ?? 0}}"
                    color="green"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />'
                />

                <!-- Total Categories Card -->
                <x-stat-card
                    title="Food Categories"
                    value="{{ $categoryCount ?? 0}}"
                    color="blue"
                    subtitle="categories"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />'
                />

                <!-- Average Calories Card -->
                <x-stat-card
                    title="Avg. Calories"
                    value="{{ $avgCalories ?? 0 }}"
                    subtitle="per serving"
                    color="red"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
                />
            </div>

            <!-- Filter and Search Section -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                        <div class="w-full md:w-1/3">
                            <label for="foodSearch" class="sr-only">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="text" name="foodSearch" id="foodSearch"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Search food items...">
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <select id="categoryFilter" name="categoryFilter"
                                    class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Categories</option>
                                @php
                                    $foodCategories = App\Models\FoodCategory::all();
                                @endphp
                                @foreach($foodCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <select id="nutritionFilter" name="nutritionFilter"
                                    class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Nutrition Focus</option>
                                <option value="low_calorie">Low Calorie</option>
                                <option value="high_protein">High Protein</option>
                                <option value="low_carb">Low Carb</option>
                                <option value="low_fat">Low Fat</option>
                                <option value="high_fiber">High Fiber</option>
                            </select>

                            <select id="sortFoods" name="sortFoods"
                                    class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="category_asc">Category (A-Z)</option>
                                <option value="calories_asc">Calories (Low to High)</option>
                                <option value="calories_desc">Calories (High to Low)</option>
                                <option value="protein_desc">Protein (High to Low)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Food Items Table -->
            <div class="flex flex-col mb-6">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Food Item
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Serving Size
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Calories
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Protein (g)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Carbs (g)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fat (g)
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="foodsTableBody" class="bg-white divide-y divide-gray-200">
                                @if($foods->count() > 0)
                                    @foreach($foods as $food)
                                        <tr class="hover:bg-gray-50 food-row"
                                            data-id="{{ $food->id }}"
                                            data-name="{{ strtolower($food->name) }}"
                                            data-category="{{ strtolower($food->category ?? '') }}"
                                            data-calories="{{ $food->nutrients['calories'] ?? 0 }}"
                                            data-protein="{{ $food->nutrients['protein_g'] ?? 0 }}"
                                            data-carbs="{{ $food->nutrients['carbs_g'] ?? 0 }}"
                                            data-fat="{{ $food->nutrients['fat_g'] ?? 0 }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($food->image_url)
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $food->image_url }}" alt="{{ $food->name }}">
                                                        </div>
                                                    @else
                                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $food->name }}</div>
                                                        <div class="text-xs text-gray-500">ID: {{ $food->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($food->category)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if($food->category->name == 'Fruits') bg-green-100 text-green-800
                                                        @elseif($food->category->name == 'Vegetables') bg-emerald-100 text-emerald-800
                                                        @elseif($food->category->name == 'Meats') bg-red-100 text-red-800
                                                        @elseif($food->category->name == 'Dairy') bg-blue-100 text-blue-800
                                                        @elseif($food->category->name == 'Grains') bg-yellow-100 text-yellow-800
                                                        @elseif($food->category->name == 'Seafood') bg-cyan-100 text-cyan-800
                                                        @elseif($food->category->name == 'Snacks') bg-orange-100 text-  orange-800
                                                        @elseif($food->category->name == 'Beverages') bg-indigo-100 text-indigo-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($food->category->name) }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Uncategorized
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $food->portion_default }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $food->nutrients['calories'] ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $food->nutrients['protein_g'] ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $food->nutrients['carbs_g'] ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $food->nutrients['fat_g'] ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button"
                                                            onclick="openViewFoodModal({{ $food->id }})"
                                                            class="text-blue-600 hover:text-blue-900">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                            onclick="openEditFoodModal({{ $food->id }})"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                            onclick="openDeleteFoodModal({{ $food->id }}, '{{ $food->name }}')"
                                                            class="text-red-600 hover:text-red-900">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No food items found</h3>
                                            <p class="mt-1 text-sm text-gray-500">Get started by adding a new food item to your database.</p>
                                            <div class="mt-6">
                                                <button type="button" onclick="openCreateFoodModal()"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                    Add Food Item
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->

                @if($foods->count() > 0)
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#"
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#"
                               class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">1</span>
                                    to
                                    <span class="font-medium">{{ min($foods->count(), 10) }}</span>
                                    of
                                    <span class="font-medium">{{ $foods->count() }}</span>
                                    results
                                </p>
                            </div>
                            @if($foods->count() > 10)
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                         aria-label="Pagination">
                                        <a href="#"
                                           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M12.707 5.x293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <a href="#" aria-current="page"
                                           class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            1
                                        </a>
                                        <a href="#"
                                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Food Modal -->
    <x-modal id="createFoodModal" title="Add New Food Item" iconType="create">
        <form action="#" method="post">
            @csrf
            <div class="mt-6 space-y-6">
                <div>
                    <label for="food_name" class="block text-sm font-medium text-gray-700">Food Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="food_name"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="e.g. Chicken Breast">
                    </div>
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Food Category</label>
                    <div class="mt-1">
                        <select id="category" name="category"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Category</option>
                            <option value="fruits">Fruits</option>
                            <option value="vegetables">Vegetables</option>
                            <option value="meats">Meats</option>
                            <option value="dairy">Dairy</option>
                            <option value="grains">Grains</option>
                            <option value="seafood">Seafood</option>
                            <option value="snacks">Snacks</option>
                            <option value="beverages">Beverages</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="portion_default" class="block text-sm font-medium text-gray-700">Default Portion</label>
                    <div class="mt-1">
                        <input type="text" name="portion_default" id="portion_default"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               placeholder="e.g. 100g or 1 cup">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="calories" class="block text-sm font-medium text-gray-700">Calories</label>
                        <div class="mt-1">
                            <input type="number" name="nutrients[calories]" id="calories"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 165">
                        </div>
                    </div>

                    <div>
                        <label for="protein_g" class="block text-sm font-medium text-gray-700">Protein (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[protein_g]" id="protein_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 31">
                        </div>
                    </div>

                    <div>
                        <label for="carbs_g" class="block text-sm font-medium text-gray-700">Carbs (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[carbs_g]" id="carbs_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 0">
                        </div>
                    </div>

                    <div>
                        <label for="fat_g" class="block text-sm font-medium text-gray-700">Fat (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[fat_g]" id="fat_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 3.6">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="fiber_g" class="block text-sm font-medium text-gray-700">Fiber (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[fiber_g]" id="fiber_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 0">
                        </div>
                    </div>

                    <div>
                        <label for="sugar_g" class="block text-sm font-medium text-gray-700">Sugar (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[sugar_g]" id="sugar_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 0">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3"
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                  placeholder="Additional information about this food item..."></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Add Food Item
                </button>
                <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeCreateFoodModal()">
                    Cancel
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Food Modal -->
    <x-modal id="editFoodModal" title="Edit Food Item" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'>
        <form id="updateFoodForm" action="" method="post">
            @csrf
            @method('PUT')
            <div class="mt-6 space-y-6">
                <input type="hidden" name="food_id" id="edit_food_id">

                <div>
                    <label for="edit_food_name" class="block text-sm font-medium text-gray-700">Food Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="edit_food_name"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <label for="edit_category" class="block text-sm font-medium text-gray-700">Food Category</label>
                    <div class="mt-1">
                        <select id="edit_category" name="category"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Select Category</option>
                            <option value="fruits">Fruits</option>
                            <option value="vegetables">Vegetables</option>
                            <option value="meats">Meats</option>
                            <option value="dairy">Dairy</option>
                            <option value="grains">Grains</option>
                            <option value="seafood">Seafood</option>
                            <option value="snacks">Snacks</option>
                            <option value="beverages">Beverages</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="edit_portion_default" class="block text-sm font-medium text-gray-700">Default Portion</label>
                    <div class="mt-1">
                        <input type="text" name="portion_default" id="edit_portion_default"
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="edit_calories" class="block text-sm font-medium text-gray-700">Calories</label>
                        <div class="mt-1">
                            <input type="number" name="nutrients[calories]" id="edit_calories"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label for="edit_protein_g" class="block text-sm font-medium text-gray-700">Protein (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[protein_g]" id="edit_protein_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label for="edit_carbs_g" class="block text-sm font-medium text-gray-700">Carbs (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[carbs_g]" id="edit_carbs_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label for="edit_fat_g" class="block text-sm font-medium text-gray-700">Fat (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[fat_g]" id="edit_fat_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="edit_fiber_g" class="block text-sm font-medium text-gray-700">Fiber (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[fiber_g]" id="edit_fiber_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label for="edit_sugar_g" class="block text-sm font-medium text-gray-700">Sugar (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[sugar_g]" id="edit_sugar_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="edit_description" name="description" rows="3"
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Update Food Item
                </button>
                <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeEditFoodModal()">
                    Cancel
                </button>
            </div>
        </form>
    </x-modal>

    <!-- View Food Modal -->
    <x-modal id="viewFoodModal" title="Food Item Details" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />'>
        <div class="mt-4">
            <div class="bg-white p-4 rounded-lg">
                <div class="flex items-center mb-4">
                    <div id="view_food_image" class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                        <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="view_food_name" class="text-lg font-medium text-gray-900">Food Name</h3>
                        <p id="view_food_category" class="text-sm text-gray-500">Category</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Serving Size</h4>
                    <p id="view_portion_default" class="text-sm text-gray-900">Serving size</p>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Nutritional Information</h4>
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Calories</span>
                            <p id="view_calories" class="text-sm font-semibold text-gray-900">0</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Protein</span>
                            <p id="view_protein_g" class="text-sm font-semibold text-gray-900">0g</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Carbs</span>
                            <p id="view_carbs_g" class="text-sm font-semibold text-gray-900">0g</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Fat</span>
                            <p id="view_fat_g" class="text-sm font-semibold text-gray-900">0g</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Fiber</span>
                            <p id="view_fiber_g" class="text-sm font-semibold text-gray-900">0g</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <span class="text-xs text-gray-500">Sugar</span>
                            <p id="view_sugar_g" class="text-sm font-semibold text-gray-900">0g</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                    <p id="view_description" class="text-sm text-gray-600">No description available.</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="viewEditFoodButton"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                Edit Food Item
            </button>
            <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    onclick="closeViewFoodModal()">
                Close
            </button>
        </div>
    </x-modal>

    <!-- Delete Food Modal -->
    <x-modal id="deleteFoodModal" title="Delete Food Item" iconType="delete">
        <div class="mt-2">
            <p class="text-sm text-gray-500" id="delete-food-text">
                Are you sure you want to delete this food item? This action cannot be undone.
            </p>
            <p class="mt-2 text-sm text-red-500">
                Warning: Deleting this food item will remove it permanently from the database.
            </p>
        </div>

        <div class="bg-gray-50 px-4 py-3 mt-6 sm:px-6 sm:flex sm:flex-row-reverse">
            <form id="deleteFoodForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeDeleteFoodModal()">
                Cancel
            </button>
        </div>
    </x-modal>

    <!-- JavaScript for modals and interactions -->
    <script>
        // Dom Elements
        const createFoodModal = document.getElementById('createFoodModal');
        const editFoodModal = document.getElementById('editFoodModal');
        const viewFoodModal = document.getElementById('viewFoodModal');
        const deleteFoodModal = document.getElementById('deleteFoodModal');
        const updateFoodForm = document.getElementById('updateFoodForm');
        const deleteFoodForm = document.getElementById('deleteFoodForm');
        const viewEditFoodButton = document.getElementById('viewEditFoodButton');

        // Search and filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const foodSearch = document.getElementById('foodSearch');
            const categoryFilter = document.getElementById('categoryFilter');
            const nutritionFilter = document.getElementById('nutritionFilter');
            const sortFoods = document.getElementById('sortFoods');

            // Handle search input
            if (foodSearch) {
                foodSearch.addEventListener('input', filterFoods);
            }

            // Handle category filter
            if (categoryFilter) {
                categoryFilter.addEventListener('change', filterFoods);
            }

            // Handle nutrition filter
            if (nutritionFilter) {
                nutritionFilter.addEventListener('change', filterFoods);
            }

            // Handle sorting
            if (sortFoods) {
                sortFoods.addEventListener('change', sortFoodItems);
            }

            // Hide success alerts after 3 seconds
            setTimeout(() => {
                const successAlert = document.getElementById('successAlert');
                if (successAlert) {
                    successAlert.style.display = 'none';
                }
            }, 3000);

            // Set up view edit button action
            if (viewEditFoodButton) {
                viewEditFoodButton.addEventListener('click', function() {
                    const foodId = this.getAttribute('data-id');
                    closeViewFoodModal();
                    openEditFoodModal(foodId);
                });
            }
        });

        // Filter foods based on search and filters
        function filterFoods() {
            const searchTerm = document.getElementById('foodSearch').value.toLowerCase();
            const categoryValue = document.getElementById('categoryFilter').value.toLowerCase();
            const nutritionValue = document.getElementById('nutritionFilter').value;

            const foodRows = document.querySelectorAll('.food-row');

            foodRows.forEach(row => {
                const foodName = row.getAttribute('data-name').toLowerCase();
                const foodCategory = row.getAttribute('data-category').toLowerCase();
                const calories = parseFloat(row.getAttribute('data-calories'));
                const protein = parseFloat(row.getAttribute('data-protein'));
                const carbs = parseFloat(row.getAttribute('data-carbs'));
                const fat = parseFloat(row.getAttribute('data-fat'));

                let matchesSearch = foodName.includes(searchTerm);
                let matchesCategory = categoryValue === '' || foodCategory === categoryValue;
                let matchesNutrition = true;

                // Apply nutrition filters
                if (nutritionValue === 'low_calorie') {
                    matchesNutrition = calories <= 200;
                } else if (nutritionValue === 'high_protein') {
                    matchesNutrition = protein >= 15;
                } else if (nutritionValue === 'low_carb') {
                    matchesNutrition = carbs <= 10;
                } else if (nutritionValue === 'low_fat') {
                    matchesNutrition = fat <= 5;
                } else if (nutritionValue === 'high_fiber') {
                    // Assuming fiber data is available
                    const fiber = parseFloat(row.getAttribute('data-fiber') || '0');
                    matchesNutrition = fiber >= 5;
                }

                if (matchesSearch && matchesCategory && matchesNutrition) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Sort food items
        function sortFoodItems() {
            const sortValue = document.getElementById('sortFoods').value;
            const foodRows = Array.from(document.querySelectorAll('.food-row'));
            const foodsTableBody = document.getElementById('foodsTableBody');

            foodRows.sort((a, b) => {
                if (sortValue === 'name_asc') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                } else if (sortValue === 'name_desc') {
                    return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                } else if (sortValue === 'category_asc') {
                    return a.getAttribute('data-category').localeCompare(b.getAttribute('data-category'));
                } else if (sortValue === 'calories_asc') {
                    return parseFloat(a.getAttribute('data-calories')) - parseFloat(b.getAttribute('data-calories'));
                } else if (sortValue === 'calories_desc') {
                    return parseFloat(b.getAttribute('data-calories')) - parseFloat(a.getAttribute('data-calories'));
                } else if (sortValue === 'protein_desc') {
                    return parseFloat(b.getAttribute('data-protein')) - parseFloat(a.getAttribute('data-protein'));
                }

                return 0;
            });

            // Clear table and append sorted rows
            while (foodsTableBody.firstChild) {
                foodsTableBody.removeChild(foodsTableBody.firstChild);
            }

            foodRows.forEach(row => {
                foodsTableBody.appendChild(row);
            });
        }

        // Modal Functions
        function openCreateFoodModal() {
            createFoodModal.classList.remove('hidden');
        }

        function closeCreateFoodModal() {
            createFoodModal.classList.add('hidden');
        }

        function openEditFoodModal(foodId) {
            // Fetch food data from server
            fetch(`/api/foods/${foodId}`)
                .then(response => response.json())
                .then(food => {
                    // Populate form fields
                    document.getElementById('edit_food_id').value = food.id;
                    document.getElementById('edit_food_name').value = food.name;
                    document.getElementById('edit_category').value = food.category || '';
                    document.getElementById('edit_portion_default').value = food.portion_default;
                    document.getElementById('edit_calories').value = food.nutrients.calories;
                    document.getElementById('edit_protein_g').value = food.nutrients.protein_g;
                    document.getElementById('edit_carbs_g').value = food.nutrients.carbs_g;
                    document.getElementById('edit_fat_g').value = food.nutrients.fat_g;
                    document.getElementById('edit_fiber_g').value = food.nutrients.fiber_g || '';
                    document.getElementById('edit_sugar_g').value = food.nutrients.sugar_g || '';
                    document.getElementById('edit_description').value = food.description || '';

                    // Set form action
                    updateFoodForm.action = `/foods/${foodId}`;

                    // Show modal
                    editFoodModal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching food data:', error);
                    alert('Error loading food data. Please try again.');
                });
        }

        function closeEditFoodModal() {
            editFoodModal.classList.add('hidden');
        }

        function openViewFoodModal(foodId) {
            // Fetch food data from server
            fetch(`/api/foods/${foodId}`)
                .then(response => response.json())
                .then(food => {
                    // Populate view fields
                    document.getElementById('view_food_name').textContent = food.name;
                    document.getElementById('view_food_category').textContent = food.category ? ucfirst(food.category) : 'Uncategorized';
                    document.getElementById('view_portion_default').textContent = food.portion_default;
                    document.getElementById('view_calories').textContent = food.nutrients.calories;
                    document.getElementById('view_protein_g').textContent = `${food.nutrients.protein_g}g`;
                    document.getElementById('view_carbs_g').textContent = `${food.nutrients.carbs_g}g`;
                    document.getElementById('view_fat_g').textContent = `${food.nutrients.fat_g}g`;
                    document.getElementById('view_fiber_g').textContent = food.nutrients.fiber_g ? `${food.nutrients.fiber_g}g` : '0g';
                    document.getElementById('view_sugar_g').textContent = food.nutrients.sugar_g ? `${food.nutrients.sugar_g}g` : '0g';
                    document.getElementById('view_description').textContent = food.description || 'No description available.';

                    // Set edit button data
                    viewEditFoodButton.setAttribute('data-id', food.id);

                    // Set food image if available
                    const imageContainer = document.getElementById('view_food_image');
                    if (food.image_url) {
                        imageContainer.innerHTML = `<img src="${food.image_url}" alt="${food.name}" class="h-16 w-16 rounded-full object-cover">`;
                    }

                    // Show modal
                    viewFoodModal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching food data:', error);
                    alert('Error loading food data. Please try again.');
                });
        }

        function closeViewFoodModal() {
            viewFoodModal.classList.add('hidden');
        }

        function openDeleteFoodModal(foodId, foodName) {
            document.getElementById('delete-food-text').textContent = `Are you sure you want to delete "${foodName}"? This action cannot be undone.`;
            deleteFoodForm.action = `/foods/${foodId}`;
            deleteFoodModal.classList.remove('hidden');
        }

        function closeDeleteFoodModal() {
            deleteFoodModal.classList.add('hidden');
        }

        // Helper function to capitalize first letter
        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
@endsection
