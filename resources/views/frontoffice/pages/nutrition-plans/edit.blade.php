@extends('layouts.app', ['activePage' => 'nutrition-plans'])

@section('title', 'Edit Nutrition Plan - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-white">
                        Edit <span class="gradient-text">Nutrition Plan</span>
                    </h1>
                    <a href="{{ route('nutrition-plans.show', $nutritionPlan) }}"
                       class="bg-white/10 hover:bg-white/20 py-2 px-4 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Plan
                    </a>
                </div>

                <form action="{{ route('nutrition-plans.update', $nutritionPlan) }}" method="POST"
                      id="nutritionPlanForm" class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                    @csrf
                    @method('PUT')

                    <!-- Plan Details Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-white mb-4 pb-2 border-b border-slate-700/50">Plan
                            Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-300 mb-2">Plan Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $nutritionPlan->name) }}"
                                       required
                                       class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration_days" class="block text-gray-300 mb-2">Duration (Days) <span
                                        class="text-red-500">*</span></label>
                                <select name="duration_days" id="duration_days" required
                                        class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @for ($i = 1; $i <= 30; $i++)
                                        <option
                                            value="{{ $i }}" {{ old('duration_days', $nutritionPlan->duration_days) == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Day' : 'Days' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $nutritionPlan->description) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_public" value="1"
                                       {{ old('is_public', $nutritionPlan->is_public) ? 'checked' : '' }}
                                       class="form-checkbox h-5 w-5 text-blue-500 rounded border-slate-700 bg-slate-900 focus:ring-0">
                                <span class="ml-2 text-gray-300">Make this plan public for other users to see</span>
                            </label>
                        </div>
                    </div>

                    <!-- Days Container -->
                    <div id="daysContainer">
                        <!-- Days will be inserted here dynamically via JavaScript -->
                    </div>

                    <!-- Add Day Button -->
                    <div class="text-center my-6">
                        <button type="button" id="addDayBtn"
                                class="bg-slate-700/80 hover:bg-slate-700 py-2 px-6 rounded-lg text-white inline-flex items-center transition">
                            <i class="fas fa-plus mr-2"></i> Add Day
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-center">
                        <button type="submit"
                                class="btn-primary py-3 px-8 rounded-lg text-white inline-flex items-center transition text-lg">
                            <i class="fas fa-save mr-2"></i> Update Nutrition Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Day Template -->
    <template id="dayTemplate">
        <div class="day-container bg-slate-700/30 rounded-lg p-5 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Day <span class="day-number">1</span></h3>
                <input type="hidden" name="days[0][id]" value="" class="day-id-input">
                <button type="button" class="remove-day-btn text-red-400 hover:text-red-300">
                    <i class="fas fa-trash"></i> Remove Day
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Day Notes</label>
                <textarea name="days[0][notes]" rows="2" placeholder="Optional notes for this day..."
                          class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Meal Sections -->
            <div class="space-y-6">
                <!-- Breakfast Section -->
                <div class="meal-section">
                    <div class="flex items-center mb-2">
                        <h4 class="text-yellow-400 font-medium"><i class="fas fa-sun mr-2"></i> Breakfast</h4>
                        <div class="ml-auto flex space-x-2">
                            <button type="button"
                                    class="add-meal-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="breakfast">
                                <i class="fas fa-utensils mr-1"></i> Add Meal
                            </button>
                            <button type="button"
                                    class="add-food-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="breakfast">
                                <i class="fas fa-apple-alt mr-1"></i> Add Food
                            </button>
                        </div>
                    </div>
                    <div class="breakfast-items-container pl-4 space-y-3">
                        <!-- Breakfast items will be added here -->
                    </div>
                </div>

                <!-- Lunch Section -->
                <div class="meal-section">
                    <div class="flex items-center mb-2">
                        <h4 class="text-orange-400 font-medium"><i class="fas fa-cloud-sun mr-2"></i> Lunch</h4>
                        <div class="ml-auto flex space-x-2">
                            <button type="button"
                                    class="add-meal-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="lunch">
                                <i class="fas fa-utensils mr-1"></i> Add Meal
                            </button>
                            <button type="button"
                                    class="add-food-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="lunch">
                                <i class="fas fa-apple-alt mr-1"></i> Add Food
                            </button>
                        </div>
                    </div>
                    <div class="lunch-items-container pl-4 space-y-3">
                        <!-- Lunch items will be added here -->
                    </div>
                </div>

                <!-- Dinner Section -->
                <div class="meal-section">
                    <div class="flex items-center mb-2">
                        <h4 class="text-purple-400 font-medium"><i class="fas fa-moon mr-2"></i> Dinner</h4>
                        <div class="ml-auto flex space-x-2">
                            <button type="button"
                                    class="add-meal-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="dinner">
                                <i class="fas fa-utensils mr-1"></i> Add Meal
                            </button>
                            <button type="button"
                                    class="add-food-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="dinner">
                                <i class="fas fa-apple-alt mr-1"></i> Add Food
                            </button>
                        </div>
                    </div>
                    <div class="dinner-items-container pl-4 space-y-3">
                        <!-- Dinner items will be added here -->
                    </div>
                </div>

                <!-- Snacks Section -->
                <div class="meal-section">
                    <div class="flex items-center mb-2">
                        <h4 class="text-green-400 font-medium"><i class="fas fa-cookie mr-2"></i> Snacks</h4>
                        <div class="ml-auto flex space-x-2">
                            <button type="button"
                                    class="add-meal-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="snack">
                                <i class="fas fa-utensils mr-1"></i> Add Meal
                            </button>
                            <button type="button"
                                    class="add-food-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 py-1 px-3 rounded-full text-xs transition"
                                    data-meal-type="snack">
                                <i class="fas fa-apple-alt mr-1"></i> Add Food
                            </button>
                        </div>
                    </div>
                    <div class="snack-items-container pl-4 space-y-3">
                        <!-- Snack items will be added here -->
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Meal Item Template -->
    <template id="mealItemTemplate">
        <div class="meal-item bg-slate-800/80 rounded-lg p-3 flex items-start">
            <div class="flex-1">
                <input type="hidden" name="days[0][meals][0][id]" value="" class="meal-id-input">
                <div class="mb-2">
                    <select name="days[0][meals][0][meal_id]" required
                            class="meal-select w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a meal...</option>
                        @foreach ($meals as $meal)
                            <option value="{{ $meal->id }}">{{ $meal->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="days[0][meals][0][meal_type]" value="breakfast" class="meal-type-input">
                <textarea name="days[0][meals][0][notes]" placeholder="Optional notes..." rows="1"
                          class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="button" class="remove-item-btn ml-2 text-red-400 hover:text-red-300 self-start">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>

    <!-- Food Item Template -->
    <template id="foodItemTemplate">
        <div class="food-item bg-slate-800/80 rounded-lg p-3 flex items-start">
            <div class="flex-1">
                <input type="hidden" name="days[0][foods][0][id]" value="" class="food-id-input">
                <div class="mb-2">
                    <select name="days[0][foods][0][food_id]" required
                            class="food-select w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a food...</option>
                        @foreach ($foods as $food)
                            <option value="{{ $food->id }}">{{ $food->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="days[0][foods][0][meal_type]" value="breakfast" class="meal-type-input">
                <div class="flex space-x-2 mb-2">
                    <div class="flex-1">
                        <input type="number" step="0.01" min="0.01" name="days[0][foods][0][quantity]" value="1"
                               required
                               class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Quantity">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="days[0][foods][0][quantity_unit]" value="serving" required
                               class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Unit">
                    </div>
                </div>
                <textarea name="days[0][foods][0][notes]" placeholder="Optional notes..." rows="1"
                          class="w-full bg-slate-900 border border-slate-700 rounded px-3 py-1.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="button" class="remove-item-btn ml-2 text-red-400 hover:text-red-300 self-start">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>

@endsection

@section('scripts')
    <script>
        /**
         * Nutrition Plan Editor - update.js
         * Handles dynamic management of nutrition plan days, meals, and food items
         *
         * Last Updated: 2025-04-21
         * Author: AymanElh
         */

        document.addEventListener('DOMContentLoaded', function() {
            // Get references to DOM elements
            const daysContainer = document.getElementById('daysContainer');
            const addDayBtn = document.getElementById('addDayBtn');
            const dayTemplate = document.getElementById('dayTemplate');
            const mealItemTemplate = document.getElementById('mealItemTemplate');
            const foodItemTemplate = document.getElementById('foodItemTemplate');
            const durationSelect = document.getElementById('duration_days');
            const nutritionPlanForm = document.getElementById('nutritionPlanForm');

            // Verify required elements exist
            if (!daysContainer || !dayTemplate || !mealItemTemplate || !foodItemTemplate) {
                console.error("Required DOM elements not found. Check template IDs.");
                return;
            }

            let dayCount = 0;

            try {
                // Load the existing plan days from the database
                const existingPlan = @json($nutritionPlan->days->load('meals', 'foodItems'));
                console.log("Loaded nutrition plan data:", existingPlan);

                if (existingPlan.length > 0) {
                    existingPlan.forEach(day => {
                        addExistingDay(day);
                    });
                } else {
                    // If no days exist, add one empty day
                    addDay();
                }

                // Update days when duration changes
                durationSelect.addEventListener('change', function() {
                    const newDayCount = parseInt(this.value, 10);

                    if (newDayCount > dayCount) {
                        // Add days
                        for (let i = dayCount; i < newDayCount; i++) {
                            addDay();
                        }
                    } else if (newDayCount < dayCount) {
                        // Remove days
                        const dayElements = daysContainer.querySelectorAll('.day-container');
                        for (let i = dayCount - 1; i >= newDayCount; i--) {
                            dayElements[i].remove();
                        }
                        dayCount = newDayCount;
                        updateDayNumbers();
                    }
                });

                // Add Day button click handler
                addDayBtn.addEventListener('click', function() {
                    addDay();
                    // Update the duration select
                    durationSelect.value = dayCount;
                });

                // Event delegation for dynamic elements
                daysContainer.addEventListener('click', function(e) {
                    // Remove Day button
                    if (e.target.classList.contains('remove-day-btn') || e.target.closest('.remove-day-btn')) {
                        const dayContainer = e.target.closest('.day-container');
                        dayContainer.remove();
                        dayCount--;
                        updateDayNumbers();
                        // Update the duration select
                        durationSelect.value = dayCount;
                    }

                    // Add Meal button
                    if (e.target.classList.contains('add-meal-btn') || e.target.closest('.add-meal-btn')) {
                        const btn = e.target.classList.contains('add-meal-btn') ? e.target : e.target.closest('.add-meal-btn');
                        const dayContainer = btn.closest('.day-container');
                        const dayIndex = Array.from(daysContainer.children).indexOf(dayContainer);
                        const mealType = btn.dataset.mealType;
                        const itemsContainer = dayContainer.querySelector(`.${mealType}-items-container`);

                        addMealItem(dayIndex, mealType, itemsContainer);
                    }

                    // Add Food button
                    if (e.target.classList.contains('add-food-btn') || e.target.closest('.add-food-btn')) {
                        const btn = e.target.classList.contains('add-food-btn') ? e.target : e.target.closest('.add-food-btn');
                        const dayContainer = btn.closest('.day-container');
                        const dayIndex = Array.from(daysContainer.children).indexOf(dayContainer);
                        const mealType = btn.dataset.mealType;
                        const itemsContainer = dayContainer.querySelector(`.${mealType}-items-container`);

                        addFoodItem(dayIndex, mealType, itemsContainer);
                    }

                    // Remove Item button
                    if (e.target.classList.contains('remove-item-btn') || e.target.closest('.remove-item-btn')) {
                        const itemContainer = e.target.closest('.meal-item, .food-item');
                        itemContainer.remove();
                    }
                });

                // Add form validation before submit
                if (nutritionPlanForm) {
                    nutritionPlanForm.addEventListener('submit', function(e) {
                        // Reset validation styles
                        this.querySelectorAll('.border-red-500').forEach(el => {
                            el.classList.remove('border-red-500');
                        });

                        // Check if there are any days
                        if (dayCount === 0) {
                            e.preventDefault();
                            alert('Please add at least one day to your nutrition plan.');
                            return;
                        }

                        // Check if all required selects are filled
                        const emptyRequiredSelects = Array.from(this.querySelectorAll('select[required]'))
                            .filter(select => !select.value);

                        if (emptyRequiredSelects.length > 0) {
                            e.preventDefault();
                            emptyRequiredSelects.forEach(select => {
                                select.classList.add('border-red-500');
                            });

                            alert('Please select all required options before submitting.');
                            emptyRequiredSelects[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                            return;
                        }

                        // Check if all required inputs are filled
                        const emptyRequiredInputs = Array.from(this.querySelectorAll('input[required]'))
                            .filter(input => !input.value.trim());

                        if (emptyRequiredInputs.length > 0) {
                            e.preventDefault();
                            emptyRequiredInputs.forEach(input => {
                                input.classList.add('border-red-500');
                            });

                            alert('Please fill in all required fields before submitting.');
                            emptyRequiredInputs[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                }

                // Helper Functions
                function addExistingDay(day) {
                    // Clone the day template
                    const dayElement = dayTemplate.content.cloneNode(true);

                    // Update day number and ID
                    dayCount++;
                    dayElement.querySelector('.day-number').textContent = dayCount;
                    dayElement.querySelector('.day-id-input').value = day.id;

                    // Set the day notes
                    dayElement.querySelector('textarea[name="days[0][notes]"]').value = day.notes || '';

                    // Update input names with the correct day index
                    updateInputNames(dayElement, 'days[0]', `days[${dayCount - 1}]`);

                    // Add to the container
                    daysContainer.appendChild(dayElement);

                    // Get the newly added day container
                    const dayContainer = daysContainer.lastElementChild;

                    // Add existing meals
                    if (day.meals && day.meals.length > 0) {
                        day.meals.forEach(meal => {
                            const mealType = meal.meal_type;
                            const itemsContainer = dayContainer.querySelector(`.${mealType}-items-container`);
                            if (itemsContainer) {
                                addExistingMealItem(dayCount - 1, mealType, itemsContainer, meal);
                            } else {
                                console.warn(`Container for meal type ${mealType} not found`);
                            }
                        });
                    }

                    // Add existing food items - FIXED PROPERTY NAME
                    if (day.foodItems && day.foodItems.length > 0) {
                        day.foodItems.forEach(foodItem => {
                            const mealType = foodItem.meal_type;
                            const itemsContainer = dayContainer.querySelector(`.${mealType}-items-container`);
                            if (itemsContainer) {
                                addExistingFoodItem(dayCount - 1, mealType, itemsContainer, foodItem);
                            } else {
                                console.warn(`Container for food type ${mealType} not found`);
                            }
                        });
                    }
                }

                function addDay() {
                    // Clone the day template
                    const dayElement = dayTemplate.content.cloneNode(true);

                    // Update day number
                    dayCount++;
                    dayElement.querySelector('.day-number').textContent = dayCount;

                    // Update input names with the correct day index
                    updateInputNames(dayElement, 'days[0]', `days[${dayCount - 1}]`);

                    // Add to the container
                    daysContainer.appendChild(dayElement);
                }

                function addExistingMealItem(dayIndex, mealType, container, mealData) {
                    // Clone the meal item template
                    const mealElement = mealItemTemplate.content.cloneNode(true);

                    // Update input names with the correct day index and meal index
                    const mealCount = container.querySelectorAll('.meal-item').length;
                    updateInputNames(mealElement, 'days[0][meals][0]', `days[${dayIndex}][meals][${mealCount}]`);

                    // Set the meal ID
                    mealElement.querySelector('.meal-id-input').value = mealData.id;

                    // Set the meal type
                    mealElement.querySelector('.meal-type-input').value = mealType;

                    // Set the meal selection
                    const mealSelect = mealElement.querySelector('.meal-select');
                    for (let i = 0; i < mealSelect.options.length; i++) {
                        if (mealSelect.options[i].value == mealData.meal_id) {
                            mealSelect.options[i].selected = true;
                            break;
                        }
                    }

                    // Set the notes
                    mealElement.querySelector('textarea').value = mealData.notes || '';

                    // Add to the container
                    container.appendChild(mealElement);
                }

                function addMealItem(dayIndex, mealType, container) {
                    // Clone the meal item template
                    const mealElement = mealItemTemplate.content.cloneNode(true);

                    // Update input names with the correct day index and meal index
                    const mealCount = container.querySelectorAll('.meal-item').length;
                    updateInputNames(mealElement, 'days[0][meals][0]', `days[${dayIndex}][meals][${mealCount}]`);

                    // Set the meal type
                    mealElement.querySelector('.meal-type-input').value = mealType;

                    // Add to the container
                    container.appendChild(mealElement);
                }

                function addExistingFoodItem(dayIndex, mealType, container, foodData) {
                    // Clone the food item template
                    const foodElement = foodItemTemplate.content.cloneNode(true);

                    // Update input names with the correct day index and food index
                    const foodCount = container.querySelectorAll('.food-item').length;
                    updateInputNames(foodElement, 'days[0][foods][0]', `days[${dayIndex}][foods][${foodCount}]`);

                    // Set the food ID
                    foodElement.querySelector('.food-id-input').value = foodData.id;

                    // Set the meal type
                    foodElement.querySelector('.meal-type-input').value = mealType;

                    // Set the food selection
                    const foodSelect = foodElement.querySelector('.food-select');
                    for (let i = 0; i < foodSelect.options.length; i++) {
                        if (foodSelect.options[i].value == foodData.food_id) {
                            foodSelect.options[i].selected = true;
                            break;
                        }
                    }

                    // Set the quantity and unit
                    foodElement.querySelector('input[name$="[quantity]"]').value = foodData.quantity;
                    foodElement.querySelector('input[name$="[quantity_unit]"]').value = foodData.quantity_unit;

                    // Set the notes
                    foodElement.querySelector('textarea').value = foodData.notes || '';

                    // Add to the container
                    container.appendChild(foodElement);
                }

                function addFoodItem(dayIndex, mealType, container) {
                    // Clone the food item template
                    const foodElement = foodItemTemplate.content.cloneNode(true);

                    // Update input names with the correct day index and food index
                    const foodCount = container.querySelectorAll('.food-item').length;
                    updateInputNames(foodElement, 'days[0][foods][0]', `days[${dayIndex}][foods][${foodCount}]`);

                    // Set the meal type
                    foodElement.querySelector('.meal-type-input').value = mealType;

                    // Add to the container
                    container.appendChild(foodElement);
                }

                function updateDayNumbers() {
                    const dayElements = daysContainer.querySelectorAll('.day-container');
                    dayElements.forEach((day, index) => {
                        day.querySelector('.day-number').textContent = index + 1;

                        // Update all input names in this day
                        updateInputNames(day, `days[${index}]`, `days[${index}]`);
                    });
                }

                function updateInputNames(element, search, replace) {
                    const inputs = element.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        if (input.name) {
                            input.name = input.name.replace(search, replace);
                        }
                    });
                }

            } catch (error) {
                console.error("Error in nutrition plan editor:", error);
                // Add a user-friendly error message to the UI
                if (daysContainer) {
                    daysContainer.innerHTML = `
                <div class="bg-red-500/20 text-red-400 p-4 rounded-lg text-center mb-4">
                    <p><i class="fas fa-exclamation-triangle mr-2"></i> An error occurred while loading the nutrition plan.</p>
                    <p class="text-sm mt-2">Please try refreshing the page or contact support if the problem persists.</p>
                </div>
            `;
                }
            }
        });

    </script>
@endsection
