@extends('layouts.admin')

@section('title', 'Meal Management')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Meal Management</h1>
            <button type="button" onclick="openCreateMealModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Meal
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Meals Card -->
            <x-stat-card
                id="totalMeals"
                title="Total Meals"
                value="{{ $totalMeals ?? 0}}"
                color="green"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />'
            />

            <!-- Avg Calories Card -->
            <x-stat-card
                id="avgCalories"
                title="Avg. Calories"
                value="some value"
                subtitle="per meal"
                color="red"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
            />

            <!-- Meal Types Card -->
            <x-stat-card
                id="mealTypes"
                title="Meal Types"
                value="{{ array_sum($mealTypeCount ?? []) }}"
                subtitle="varieties"
                color="blue"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'
            />
        </div>

        <!-- Meals Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Meals List
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Manage your meals and their nutritional information.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Meal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Calories
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created By
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($meals as $meal)
                        <tr class="meal-row" data-id="{{ $meal->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($meal->image_url)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $meal->image_url }}" alt="{{ $meal->name }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $meal->name }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">
                                            {{ \Illuminate\Support\Str::limit($meal->description, 60) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $meal->items_count ?? $meal->items->count() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ round($meal->total_calories) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $meal->creator->name ?? 'System' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.meals.show', $meal->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    View
                                </a>
                                <button type="button" onclick="openEditMealModal({{ $meal->id }})" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    Edit
                                </button>
                                <button type="button" onclick="confirmDeleteMeal({{ $meal->id }}, '{{ $meal->name }}')" class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                No meals found. Create your first meal!
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $meals->links() }}
            </div>
        </div>
    </div>

    <!-- Create Meal Modal -->
    <x-modal id="createMealModal" title="Create New Meal" iconType="create" maxWidth="2xl">
        <form id="createMealForm" method="POST" action="{{ route('admin.meals.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Meal Name</label>
                    <input type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Meal Type</label>
                    <select name="type" id="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch" selected>Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>

                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input type="text" name="image_url" id="image_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-2 border-t pt-4 mt-2">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-medium text-gray-900">Food Items</h3>
                        <button type="button" onclick="addFoodItem()" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-0.5 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Food
                        </button>
                    </div>

                    <div id="food-items-container" class="space-y-2">
                        <!-- Food items will be added here dynamically -->
                    </div>

                    <div id="no-food-items" class="text-center text-gray-500 p-4 border border-dashed rounded-md">
                        No food items added. Click "Add Food" to begin.
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <button type="button" onclick="submitCreateMealForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                Create Meal
            </button>
            <button type="button" onclick="closeCreateMealModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        @endslot
    </x-modal>

    <!-- Edit Meal Modal -->
    <x-modal id="editMealModal" title="Edit Meal" iconType="edit" maxWidth="2xl">
        <form id="editMealForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_meal_id" name="id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="col-span-2">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Meal Name</label>
                    <input type="text" name="name" id="edit_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-2">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>

                <div>
                    <label for="edit_type" class="block text-sm font-medium text-gray-700">Meal Type</label>
                    <select name="type" id="edit_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>

                <div>
                    <label for="edit_image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input type="text" name="image_url" id="edit_image_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-2 border-t pt-4 mt-2">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-medium text-gray-900">Food Items</h3>
                        <button type="button" onclick="addFoodItemToEdit()" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-0.5 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Food
                        </button>
                    </div>

                    <div id="edit-food-items-container" class="space-y-2">
                        <!-- Food items will be added here dynamically -->
                    </div>

                    <div id="edit-no-food-items" class="text-center text-gray-500 p-4 border border-dashed rounded-md">
                        No food items added. Click "Add Food" to begin.
                    </div>
                </div>
            </div>
        </form>

        @slot('footer')
            <button type="button" onclick="submitEditMealForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                Update Meal
            </button>
            <button type="button" onclick="closeEditMealModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        @endslot
    </x-modal>

    <!-- Delete Meal Modal -->
    <x-modal id="deleteMealModal" title="Delete Meal" iconType="delete" maxWidth="md">
        <div class="mt-2">
            <p class="text-sm text-gray-500" id="delete-meal-text">
                Are you sure you want to delete this meal?
            </p>
        </div>

        @slot('footer')
            <form id="deleteMealForm" method="POST" action="" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            <button type="button" onclick="closeDeleteMealModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        @endslot
    </x-modal>

    <!-- Food Search Modal -->
    <x-modal id="foodSearchModal" title="Select a Food Item" iconType="create" maxWidth="lg">
        <div class="mt-4">
            <label for="food-search-input" class="block text-sm font-medium text-gray-700">Search Foods</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="text" name="food-search" id="food-search-input" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by name...">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="mt-4" id="food-search-results">
            <div class="text-center text-gray-500 py-4">
                Type to search for foods
            </div>
        </div>

        <div class="hidden mt-4" id="food-quantity-section">
            <div class="border-t pt-4">
                <div id="selected-food-details" class="flex items-center mb-4">
                    <!-- Selected food details will be rendered here -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="food-quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="food-quantity" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="1" min="0.01" step="0.01">
                    </div>

                    <div>
                        <label for="food-quantity-unit" class="block text-sm font-medium text-gray-700">Unit</label>
                        <select id="food-quantity-unit" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="serving">Serving</option>
                            <option value="g">Grams (g)</option>
                            <option value="oz">Ounces (oz)</option>
                            <option value="cup">Cup</option>
                            <option value="tbsp">Tablespoon</option>
                            <option value="tsp">Teaspoon</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @slot('footer')
            <button type="button" id="add-selected-food-btn" onclick="addSelectedFood()" class="hidden w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                Add to Meal
            </button>
            <button type="button" onclick="closeFoodSearchModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        @endslot
    </x-modal>

@endsection

@section('scripts')
    <script src="{{ asset('js/admin/meals.js') }}"></script>
@endsection
