@extends('layouts.app')

@section('title', 'Create nutrition plan - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-white">
                        Create Your <span class="gradient-text">Nutrition Plan</span>
                    </h1>
                    <a href="{{ route('nutrition-plans.index') }}"
                       class="bg-white/10 hover:bg-white/20 py-2 px-4 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Plans
                    </a>
                </div>

                <form action="{{ route('nutrition-plans.store') }}" method="POST" id="nutritionPlanForm"
                      class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                    @csrf

                    <!-- Plan Details Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-white mb-4 pb-2 border-b border-slate-700/50">Plan
                            Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-300 mb-2">Plan Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
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
                                            value="{{ $i }}" {{ old('duration_days', 7) == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Day' : 'Days' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_public" value="1"
                                       {{ old('is_public') ? 'checked' : '' }}
                                       class="form-checkbox h-5 w-5 text-blue-500 rounded border-slate-700 bg-slate-900 focus:ring-0">
                                <span class="ml-2 text-gray-300">Make this plan public for other users to see</span>
                            </label>
                        </div>
                    </div>

                    <!-- Days Container (We'll add JavaScript later to populate this) -->
                    <div id="daysContainer">
                        <p class="text-center text-gray-400">No days added yet. Use the button below to add days to your
                            plan.</p>
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
                            <i class="fas fa-save mr-2"></i> Create Nutrition Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Day template -->
    <template id="dayTemplate">
        <div class="day-container bg-slate-700/30 rounded-lg p-5 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Day <span class="day-number">1</span></h3>
                <button type="button" class="remove-day-btn text-red-400 hover:text-red-300">
                    <i class="fas fa-trash"></i> Remove Day
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Day Notes</label>
                <textarea name="days[0][notes]" rows="2" placeholder="Optional notes for this day..."
                          class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Meal Section -->
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

    <!-- Meal Item template -->
    <template id="mealItemTemplate">
        <div class="meal-item bg-slate-800/80 rounded-lg p-3 flex items-start">
            <div class="flex-1">
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

    <!-- Food Item template -->
    <template id="foodItemTemplate">
        <div class="food-item bg-slate-800/80 rounded-lg p-3 flex items-start">
            <div class="flex-1">
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
    <script src="{{ asset('js/createNutritionPlan.js') }}"></script>
@endsection
