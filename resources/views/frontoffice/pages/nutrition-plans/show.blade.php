@extends('layouts.app', ['activePage' => 'nutrition-plans'])

@section('title', $nutritionPlan->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="mb-10">
                    <div class="flex flex-wrap items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-white">{{ $nutritionPlan->name }}</h1>

                        <!-- Author Info -->
                        <div class="flex items-center mt-2 sm:mt-0">
                            <img src="{{ $nutritionPlan->user->profile_photo_url }}"
                                 alt="{{ $nutritionPlan->user->name }}" class="h-10 w-10 rounded-full mr-3">
                            <div>
                                <p class="text-sm text-gray-400">Created by</p>
                                <p class="text-white font-medium">{{ $nutritionPlan->user_id === auth()->id() ? 'You' : $nutritionPlan->user->name }}</p>
                            </div>

                            @if($nutritionPlan->is_public)
                                <span class="ml-4 bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-globe mr-1"></i> Public
                            </span>
                            @else
                                <span class="ml-4 bg-gray-500/20 text-gray-400 px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-lock mr-1"></i> Private
                            </span>
                            @endif
                        </div>
                    </div>

                    @if($nutritionPlan->description)
                        <p class="text-gray-400 mb-6">{{ $nutritionPlan->description }}</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-slate-800/50 rounded-lg p-4 flex items-center">
                            <div class="bg-blue-500/20 p-3 rounded-full mr-4">
                                <i class="fas fa-calendar-day text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Duration</p>
                                <p class="text-white font-medium">{{ $nutritionPlan->duration_days }} {{ $nutritionPlan->duration_days == 1 ? 'Day' : 'Days' }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-lg p-4 flex items-center">
                            <div class="bg-green-500/20 p-3 rounded-full mr-4">
                                <i class="fas fa-fire text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Average Daily Calories</p>
                                <p class="text-white font-medium">{{ $nutritionPlan->daily_average_calories }}
                                    calories</p>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-lg p-4 flex items-center">
                            <div class="bg-purple-500/20 p-3 rounded-full mr-4">
                                <i class="fas fa-utensils text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Total Items</p>
                                <p class="text-white font-medium">
                                    {{ $nutritionPlan->days->flatMap->meals->count() }} meals,
                                    {{ $nutritionPlan->days->flatMap->foodItems->count() }} foods
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Navigation -->
                    <div class="bg-slate-800/50 rounded-lg p-4 mb-8">
                        <h3 class="text-white font-medium mb-3">Jump to Day:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($nutritionPlan->days as $day)
                                <a href="#day-{{ $day->day_number }}"
                                   class="bg-slate-700 hover:bg-slate-600 px-3 py-1 rounded-md text-white text-sm transition">
                                    Day {{ $day->day_number }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Days -->
                <div class="space-y-12">
                    @foreach($nutritionPlan->days as $day)
                        <div id="day-{{ $day->day_number }}"
                             class="bg-slate-800/30 rounded-xl overflow-hidden shadow-lg">
                            <div class="bg-slate-700/50 p-4">
                                <h2 class="text-xl font-semibold text-white">Day {{ $day->day_number }}</h2>
                                @if($day->notes)
                                    <p class="text-gray-400 mt-1">{{ $day->notes }}</p>
                                @endif
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Breakfast -->
                                <div class="meal-block">
                                    <div class="flex items-center mb-4">
                                        <i class="fas fa-sun text-yellow-400 mr-3"></i>
                                        <h3 class="text-lg font-medium text-white">Breakfast</h3>
                                    </div>

                                    @if($day->breakfast_items->count() > 0)
                                        <div class="space-y-4 pl-8">
                                            @foreach($day->breakfast_items as $item)
                                                @if($item['type'] === 'meal')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-blue-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-utensils text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->meal->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">{{ $item['data']->meal->description }}</p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->meal->totalCalories() }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($item['type'] === 'food')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-green-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-apple-alt text-green-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->food->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">
                                                                    {{ $item['data']->quantity }} {{ $item['data']->quantity_unit }}
                                                                </p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->food->getCalories() * $item['data']->quantity }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 pl-8">No breakfast items planned.</p>
                                    @endif
                                </div>

                                <!-- Lunch -->
                                <div class="meal-block">
                                    <div class="flex items-center mb-4">
                                        <i class="fas fa-cloud-sun text-orange-400 mr-3"></i>
                                        <h3 class="text-lg font-medium text-white">Lunch</h3>
                                    </div>

                                    @if($day->lunch_items->count() > 0)
                                        <div class="space-y-4 pl-8">
                                            @foreach($day->lunch_items as $item)
                                                <!-- Similar structure to breakfast -->
                                                @if($item['type'] === 'meal')
                                                    <!-- Meal display -->
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-blue-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-utensils text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->meal->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">{{ $item['data']->meal->description }}</p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                        class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                    class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->meal->totalCalories() }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($item['type'] === 'food')
                                                    <!-- Food display -->
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-green-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-apple-alt text-green-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->food->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">
                                                                    {{ $item['data']->quantity }} {{ $item['data']->quantity_unit }}
                                                                </p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                        class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                    class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->food->getCalories() * $item['data']->quantity }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 pl-8">No lunch items planned.</p>
                                    @endif
                                </div>

                                <!-- Dinner -->
                                <div class="meal-block">
                                    <div class="flex items-center mb-4">
                                        <i class="fas fa-moon text-purple-400 mr-3"></i>
                                        <h3 class="text-lg font-medium text-white">Dinner</h3>
                                    </div>

                                    @if($day->dinner_items->count() > 0)
                                        <div class="space-y-4 pl-8">
                                            <!-- Similar structure to breakfast -->
                                        </div>
                                        <div class="space-y-4 pl-8">
                                            @foreach($day->dinner_items as $item)
                                                @if($item['type'] === 'meal')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-blue-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-utensils text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->meal->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">{{ $item['data']->meal->description }}</p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->meal->totalCalories() }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($item['type'] === 'food')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-green-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-apple-alt text-green-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->food->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">
                                                                    {{ $item['data']->quantity }} {{ $item['data']->quantity_unit }}
                                                                </p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->food->getCalories() * $item['data']->quantity }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 pl-8">No dinner items planned.</p>
                                    @endif
                                </div>

                                <!-- Snacks -->
                                <div class="meal-block">
                                    <div class="flex items-center mb-4">
                                        <i class="fas fa-cookie text-green-400 mr-3"></i>
                                        <h3 class="text-lg font-medium text-white">Snacks</h3>
                                    </div>

                                    @if($day->snack_items->count() > 0)
                                        <div class="space-y-4 pl-8">
                                            @foreach($day->snack_items as $item)
                                                @if($item['type'] === 'meal')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-blue-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-utensils text-blue-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->meal->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">{{ $item['data']->meal->description }}</p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->meal->totalCalories() }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($item['type'] === 'food')
                                                    <div class="bg-slate-700/30 rounded-lg p-4">
                                                        <div class="flex items-start">
                                                            <div class="bg-green-500/20 p-2 rounded-full mr-4 mt-1">
                                                                <i class="fas fa-apple-alt text-green-400"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="text-white font-medium">{{ $item['data']->food->name }}</h4>
                                                                <p class="text-gray-400 text-sm mt-1">
                                                                    {{ $item['data']->quantity }} {{ $item['data']->quantity_unit }}
                                                                </p>

                                                                @if($item['data']->notes)
                                                                    <div
                                                                            class="mt-2 bg-slate-700/50 p-2 rounded-md text-gray-300 text-sm">
                                                                        <i class="fas fa-info-circle text-blue-400 mr-2"></i> {{ $item['data']->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex flex-wrap gap-2 mt-3">
                                                                <span
                                                                        class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">
                                                                    {{ $item['data']->food->getCalories() * $item['data']->quantity }} calories
                                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 pl-8">No snacks planned.</p>
                                    @endif
                                </div>

                                <!-- Day Nutritional Summary -->
                                <div class="mt-8 pt-6 border-t border-slate-700/50">
                                    <h3 class="text-white font-medium mb-4">Daily Nutritional Summary</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                        <div class="bg-slate-700/30 rounded-lg p-3 text-center">
                                            <p class="text-blue-400 font-bold text-xl">{{ $day->total_calories }}</p>
                                            <p class="text-gray-400 text-sm">Calories</p>
                                        </div>
                                        <!-- Add more nutrition info here if available -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center mt-10 space-x-4">
                    @if($nutritionPlan->user_id === auth()->id())
                        <a href="{{ route('nutrition-plans.edit', $nutritionPlan) }}"
                           class="btn-primary py-2 px-6 rounded-lg text-white inline-flex items-center transition">
                            <i class="fas fa-edit mr-2"></i> Edit Plan
                        </a>

                        <form action="{{ route('nutrition-plans.destroy', $nutritionPlan) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this nutrition plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 py-2 px-6 rounded-lg inline-flex items-center transition">
                                <i class="fas fa-trash-alt mr-2"></i> Delete Plan
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('nutrition-plans.index') }}"
                       class="bg-white/10 hover:bg-white/20 py-2 px-6 rounded-lg text-white inline-flex items-center transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Plans
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
