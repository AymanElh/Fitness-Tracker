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

            <!-- Flash messages with js -->
            <div id="flashMessages"></div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                <!-- Total Foods Card -->
                <x-stat-card
                    id="totalFoods"
                    title="Total Food Items"
                    value="{{ $totalFoods ?? 0}}"
                    color="green"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />'
                />

                <!-- Total Categories Card -->
                <x-stat-card
                    id="totalCategories"
                    title="Food Categories"
                    value="{{ $categoryCount ?? 0}}"
                    color="blue"
                    subtitle="categories"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />'
                />

                <!-- Average Calories Card -->
                <x-stat-card
                    id="avgCalories"
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

                                <tr id="loading-indicator">
                                    <td colspan="8" class="px-6 py-4 text-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500 inline"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Loading food items...
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Create Food Modal -->
    <x-modal id="createFoodModal" title="Add New Food Item" iconType="create">
        <form id="createFoodForm" action="" method="post">
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
                            @foreach($foodCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
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
                            <span class="text-red-500 text-sm mt-1 error-message"></span>
                        </div>
                    </div>

                    <div>
                        <label for="protein_g" class="block text-sm font-medium text-gray-700">Protein (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[protein_g]" id="protein_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 31">
                            <span class="text-red-500 text-sm mt-1 error-message"></span>
                        </div>
                    </div>

                    <div>
                        <label for="carbs_g" class="block text-sm font-medium text-gray-700">Carbs (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[carbs_g]" id="carbs_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 0">
                            <span class="text-red-500 text-sm mt-1 error-message"></span>
                        </div>
                    </div>

                    <div>
                        <label for="fat_g" class="block text-sm font-medium text-gray-700">Fat (g)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="nutrients[fat_g]" id="fat_g"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 3.6">
                            <span class="text-red-500 text-sm mt-1 error-message"></span>
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
                            <span class="text-red-500 text-sm mt-1 error-message"></span>
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
                    <label for="description" class="block text-sm font-medium text-gray-700">Description
                        (Optional)</label>
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
    <x-modal id="editFoodModal" title="Edit Food Item"
             icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'>
        <form id="updateFoodForm" action="">
            @csrf
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
                            @foreach($foodCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="edit_portion_default" class="block text-sm font-medium text-gray-700">Default
                        Portion</label>
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
            <form id="deleteFoodForm" action="">
                @csrf
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    onclick="closeDeleteFoodModal()">
                Cancel
            </button>
        </div>
    </x-modal>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/foods.js') }}"></script>
{{--    @vite('resources/js/admin/foods.js')--}}
@endsection
