@extends('layouts.admin')

@section('title', 'Food Items Management')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-8 bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Food Items Management</h1>
                        <p class="mt-2 text-gray-600">Manage the nutrition database for your fitness tracker</p>
                    </div>
                    <div>
                        <button id="openFoodSearchModal" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Food Item
                        </button>
                    </div>
                </div>
            </div>

            <!-- Food Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Food Items Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-green-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Food Items</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalFoodItems ?? '0' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recently Added Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-blue-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Recently Added</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $recentlyAdded ?? '0' }}</h3>
                                    <span class="ml-2 text-sm font-medium text-gray-500">last 7 days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Usage Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-purple-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">API Usage</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $apiUsage ?? '0' }}/1000</h3>
                                    <span class="ml-2 text-sm font-medium text-gray-500">requests</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search food items" type="search">
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="category" class="text-sm font-medium text-gray-700">Category:</label>
                        <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Categories</option>
                            <option value="fruits">Fruits</option>
                            <option value="vegetables">Vegetables</option>
                            <option value="protein">Protein</option>
                            <option value="grains">Grains</option>
                            <option value="dairy">Dairy</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Food Items Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Food Database</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calories</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protein</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carbs</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added Date</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($foodItems ?? [] as $foodItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($foodItem->image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $foodItem->image }}" alt="{{ $foodItem->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $foodItem->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: {{ $foodItem->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($foodItem->calories, 1) }}</div>
                                    <div class="text-xs text-gray-500">kcal</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($foodItem->protein, 1) }}g</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($foodItem->carbohydrates, 1) }}g</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($foodItem->fat, 1) }}g</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $foodItem->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button
                                            data-food-id="{{ $foodItem->id }}"
                                            class="edit-food-btn text-indigo-600 hover:text-indigo-900"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            data-food-id="{{ $foodItem->id }}"
                                            class="delete-food-btn text-red-600 hover:text-red-900"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">No food items found</p>
                                        <button id="emptyStateAddFoodBtn" class="mt-3 px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700">
                                            Add Your First Food Item
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    @if(isset($foodItems) && $foodItems->hasPages())
                        {{ $foodItems->links() }}
                    @else
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ isset($foodItems) ? $foodItems->firstItem() ?? 0 : 0 }}</span>
                                    to
                                    <span class="font-medium">{{ isset($foodItems) ? $foodItems->lastItem() ?? 0 : 0 }}</span>
                                    of
                                    <span class="font-medium">{{ isset($foodItems) ? $foodItems->total() ?? 0 : 0 }}</span>
                                    results
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Food Search Modal -->
    <div id="foodSearchModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Search Food Database
                            </h3>
                            <div class="mt-4">
                                <input id="apiSearchInput" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" type="text" placeholder="Search for a food item...">

                                <div id="apiSearchResults" class="mt-4 max-h-60 overflow-y-auto">
                                    <!-- Search results will appear here -->
                                    <div class="text-center py-4 text-gray-500">
                                        Type to search for food items
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="closeModalBtn" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this to the bottom of your view -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search Modal Functionality
            const openModalBtn = document.getElementById('openFoodSearchModal');
            const emptyStateAddFoodBtn = document.getElementById('emptyStateAddFoodBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const foodSearchModal = document.getElementById('foodSearchModal');
            const apiSearchInput = document.getElementById('apiSearchInput');
            const apiSearchResults = document.getElementById('apiSearchResults');

            // Open modal
            openModalBtn?.addEventListener('click', openModal);
            emptyStateAddFoodBtn?.addEventListener('click', openModal);

            // Close modal
            closeModalBtn?.addEventListener('click', closeModal);
            modalBackdrop?.addEventListener('click', closeModal);

            function openModal() {
                foodSearchModal.classList.remove('hidden');
                setTimeout(() => {
                    apiSearchInput.focus();
                }, 100);
            }

            function closeModal() {
                foodSearchModal.classList.add('hidden');
            }

            // API Search Functionality
            let searchTimeout;

            apiSearchInput?.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                console.log(query);
                if (query.length < 2) {
                    apiSearchResults.innerHTML = '<div class="text-center py-4 text-gray-500">Type at least 2 characters to search</div>';
                    return;
                }

                // Show loading
                apiSearchResults.innerHTML = `
                                                                        <div class="flex justify-center items-center py-4">
                                                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                            </svg>
                                                                            <span class="text-gray-500">Searching...</span>
                                                                        </div>
                                                                    `;

                // Debounce search to avoid too many requests
                searchTimeout = setTimeout(() => {
                    fetchFoodResults(query);
                }, 500);
            });

            // This function would make an API call to your Laravel backend
            function fetchFoodResults(query) {
                fetch(`/api/food/search?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        renderSearchResults(data);
                    })
                    .catch(error => {
                        console.error('Error searching food:', error);
                        apiSearchResults.innerHTML = `
                                                                            <div class="text-center py-4 text-red-500">
                                                                                Error searching for food items. Please try again.
                                                                            </div>
                                                                        `;
                    });
            }

            // Render search results in the modal
            function renderSearchResults(data) {
                if (!data || !data.hints || data.hints.length === 0) {
                    apiSearchResults.innerHTML = `
                                                                            <div class="text-center py-4 text-gray-500">
                                                                                No food items found. Try a different search term.
                                                                            </div>
                                                                        `;
                    return;
                }

                const resultsHtml = data.hints.map(item => {
                    const food = item.food;
                    const measures = item.measures || [];

                    return `
                                                                            <div class="food-item p-3 border-b border-gray-200 hover:bg-gray-50">
                                                                                <div class="flex items-center">
                                                                                    <div class="flex-shrink-0 h-12 w-12">
                                                                                        ${food.image ?
                        `<img class="h-12 w-12 rounded-full object-cover" src="${food.image}" alt="${food.label}">` :
                        `<div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                                                                                </svg>
                                                                                            </div>`
                    }
                                                                                    </div>
                                                                                    <div class="ml-4 flex-1">
                                                                                        <div class="text-sm font-medium text-gray-900">${food.label}</div>
                                                                                        <div class="text-xs text-gray-500">
                                                                                            ${food.nutrients ?
                        `${Math.round(food.nutrients.ENERC_KCAL || 0)} kcal | ${(food.nutrients.PROCNT || 0).toFixed(1)}g protein | ${(food.nutrients.FAT || 0).toFixed(1)}g fat` :
                        'Nutrition data not available'
                    }
                                                                                        </div>
                                                                                    </div>
                                                                                    <button
                                                                                        class="add-food-btn ml-4 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                                        data-food-id="${food.foodId}"
                                                                                        data-food-label="${food.label}"
                                                                                        data-food-image="${food.image || ''}"
                                                                                        data-food-calories="${food.nutrients ? food.nutrients.ENERC_KCAL || 0 : 0}"
                                                                                        data-food-protein="${food.nutrients ? food.nutrients.PROCNT || 0 : 0}"
                                                                                        data-food-carbs="${food.nutrients ? food.nutrients.CHOCDF || 0 : 0}"
                                                                                        data-food-fat="${food.nutrients ? food.nutrients.FAT || 0 : 0}"
                                                                                        data-food-fiber="${food.nutrients ? food.nutrients.FIBTG || 0 : 0}"
                                                                                    >
                                                                                        Add
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        `;
                }).join('');

                apiSearchResults.innerHTML = resultsHtml;

                // Add event listeners to the Add buttons
                document.querySelectorAll('.add-food-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const foodData = {
                            name: this.dataset.foodLabel,
                            api_food_id: this.dataset.foodId,
                            image: this.dataset.foodImage,
                            calories: parseFloat(this.dataset.foodCalories),
                            protein: parseFloat(this.dataset.foodProtein),
                            carbohydrates: parseFloat(this.dataset.foodCarbs),
                            fat: parseFloat(this.dataset.foodFat),
                            fiber: parseFloat(this.dataset.foodFiber)
                        };

                        // Save to database
                        saveFoodItem(foodData);
                    });
                });
            }

            function saveFoodItem(foodData) {
                // Show saving indicator in the button
                const button = event.target;
                const originalText = button.textContent;
                button.disabled = true;
                button.textContent = 'Saving...';

                fetch('/api/food-items', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(foodData)
                })
                    .then(response => response.json())
                    .then(data => {
                        // Show success message
                        button.textContent = 'Added!';
                        button.classList.remove('bg-indigo-100', 'text-indigo-700');
                        button.classList.add('bg-green-100', 'text-green-700');

                        // Close modal and refresh page after a brief delay
                        setTimeout(() => {
                            closeModal();
                            window.location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.error('Error saving food item:', error);
                        button.textContent = 'Error';
                        button.classList.remove('bg-indigo-100', 'text-indigo-700');
                        button.classList.add('bg-red-100', 'text-red-700');

                        setTimeout(() => {
                            button.textContent = originalText;
                            button.classList.remove('bg-red-100', 'text-red-700');
                            button.classList.add('bg-indigo-100', 'text-indigo-700');
                            button.disabled = false;
                        }, 2000);
                    });
            }

            // Setup edit and delete buttons
            document.querySelectorAll('.edit-food-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const foodId = this.dataset.foodId;
                    // Redirect to edit page or open edit modal
                    window.location.href = `/admin/food-items/${foodId}/edit`;
                });
            });

            document.querySelectorAll('.delete-food-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const foodId = this.dataset.foodId;
                    if (confirm('Are you sure you want to delete this food item?')) {
                        // Make delete request
                        fetch(`/api/food-items/${foodId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                // Refresh page
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Error deleting food item:', error);
                                alert('Error deleting food item. Please try again.');
                            });
                    }
                });
            });

            // Filter functionality
            const searchInput = document.getElementById('search');
            const categorySelect = document.getElementById('category');

            searchInput?.addEventListener('input', debounce(function() {
                applyFilters();
            }, 500));

            categorySelect?.addEventListener('change', function() {
                applyFilters();
            });

            function applyFilters() {
                const searchTerm = searchInput?.value.trim().toLowerCase();
                const category = categorySelect?.value;

                // Build query string for filters
                const params = new URLSearchParams(window.location.search);

                if (searchTerm) {
                    params.set('search', searchTerm);
                } else {
                    params.delete('search');
                }

                if (category) {
                    params.set('category', category);
                } else {
                    params.delete('category');
                }

                // Redirect with filters
                window.location.href = window.location.pathname + '?' + params.toString();
            }

            // Utility function for debouncing
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        });
    </script>
@endsection
