@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row items-start gap-8">
                    <!-- Profile Sidebar -->
                    <div class="w-full md:w-1/3">
                        <div class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 mb-4 relative">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                </div>

                                <h2 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h2>
                                <p class="text-blue-400 mb-4">{{ $user->email }}</p>

                                <a href="{{ route('profile.edit') }}" class="btn-primary w-full text-center py-2 px-4 rounded-lg text-white transition mb-2">
                                    <i class="fas fa-user-edit mr-2"></i> Edit Profile
                                </a>

                                <a href="{{ route('profile.password.edit') }}" class="bg-slate-700 hover:bg-slate-600 w-full text-center py-2 px-4 rounded-lg text-white transition">
                                    <i class="fas fa-lock mr-2"></i> Change Password
                                </a>
                            </div>

                            <div class="mt-6 pt-6 border-t border-slate-700/50">
                                <h3 class="text-lg font-semibold text-white mb-3">Stats</h3>

                                <div class="space-y-3">
                                    @if($user->date_of_birth)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400"><i class="fas fa-birthday-cake mr-2"></i> Age:</span>
                                            <span class="text-white">{{ $user->age }} years</span>
                                        </div>
                                    @endif

                                    @if($user->weight)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400"><i class="fas fa-weight mr-2"></i> Weight:</span>
                                            <span class="text-white">{{ $user->weight }} kg</span>
                                        </div>
                                    @endif

                                    @if($user->height)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400"><i class="fas fa-ruler-vertical mr-2"></i> Height:</span>
                                            <span class="text-white">{{ $user->height }} cm</span>
                                        </div>
                                    @endif

                                    @if($user->bmi)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400"><i class="fas fa-calculator mr-2"></i> BMI:</span>
                                            <span class="text-white">{{ $user->bmi }} ({{ $user->bmi_category }})</span>
                                        </div>
                                    @endif

                                    @if($user->gender)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400"><i class="fas fa-venus-mars mr-2"></i> Gender:</span>
                                            <span class="text-white">{{ ucfirst(str_replace('_', ' ', $user->gender)) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="w-full md:w-2/3">
                        <!-- Success messages -->
                        @if (session('success'))
                            <div class="bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- About Me Section -->
                        <div class="bg-slate-800/50 rounded-xl p-6 shadow-lg mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4 pb-2 border-b border-slate-700/50">
                                <i class="fas fa-user mr-2"></i> About Me
                            </h3>

                            <div class="text-gray-300">
                                @if($user->bio)
                                    <p>{{ $user->bio }}</p>
                                @else
                                    <p class="text-gray-500 italic">No bio information provided. <a href="{{ route('profile.edit') }}" class="text-blue-400 hover:underline">Add one now</a>.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Your Plans Section -->
                        <div class="bg-slate-800/50 rounded-xl p-6 shadow-lg mb-6">
                            <h3 class="text-xl font-semibold text-white mb-4 pb-2 border-b border-slate-700/50">
                                <i class="fas fa-utensils mr-2"></i> Your Nutrition Plans
                            </h3>

                            @php
                                $nutritionPlans = \App\Models\NutritionPlan::where('user_id', $user->id)->latest()->take(3)->get();
                            @endphp

                            @if($nutritionPlans->count() > 0)
                                <div class="space-y-4">
                                    @foreach($nutritionPlans as $plan)
                                        <div class="bg-slate-700/30 rounded-lg p-4 flex justify-between items-center">
                                            <div>
                                                <h4 class="text-white font-medium">{{ $plan->name }}</h4>
                                                <p class="text-gray-400 text-sm">{{ $plan->duration_days }} days</p>
                                            </div>
                                            <a href="{{ route('nutrition-plans.show', $plan) }}" class="text-blue-400 hover:underline">
                                                View <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ route('nutrition-plans.index') }}" class="text-blue-400 hover:underline">
                                        View all nutrition plans <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 italic">You haven't created any nutrition plans yet.</p>
                                <div class="mt-4">
                                    <a href="{{ route('nutrition-plans.create') }}" class="inline-flex items-center text-blue-400 hover:underline">
                                        <i class="fas fa-plus mr-2"></i> Create your first nutrition plan
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Your Exercises Section -->
                        <div class="bg-slate-800/50 rounded-xl p-6 shadow-lg">
                            <h3 class="text-xl font-semibold text-white mb-4 pb-2 border-b border-slate-700/50">
                                <i class="fas fa-dumbbell mr-2"></i> Your Exercise Plans
                            </h3>

                            @php
                                // Replace with your actual exercise plans model
                                $exercisePlans =  \App\Models\ExercisePlan::where('user_id', $user->id)->latest()->take(3)->get();
                            @endphp

                            @if(!empty($exercisePlans))
                                <div class="space-y-4">
                                    @foreach($exercisePlans as $plan)
                                        <div class="bg-slate-700/30 rounded-lg p-4 flex justify-between items-center">
                                            <div>
                                                <h4 class="text-white font-medium">{{ $plan->name }}</h4>
                                                <p class="text-gray-400 text-sm">{{ $plan->duration_days }} days</p>
                                            </div>
                                            <a href="#" class="text-blue-400 hover:underline">
                                                View <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-400 hover:underline">
                                        View all exercise plans <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 italic">You haven't created any exercise plans yet.</p>
                                <div class="mt-4">
                                    <a href="#" class="inline-flex items-center text-blue-400 hover:underline">
                                        <i class="fas fa-plus mr-2"></i> Create your first exercise plan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
