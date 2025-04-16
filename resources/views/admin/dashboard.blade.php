@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class=" bg-gray-50 min-h-screen">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-8 bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                <p class="mt-2 text-gray-600">Welcome to your admin dashboard</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-indigo-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total users</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</h3>
                                    <span class="ml-2 text-sm font-medium {{ $percentChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $percentChange >= 0 ? '+' : '' }}{{ $percentChange }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Plans Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-green-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Meals</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalMeals) }}</h3>
                                    <span class="ml-2 text-sm font-medium text-gray-600">
                                        Avg: {{ $avgCaloriesPerMeal }} cal
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Exercises Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-red-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Exercises</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalExercises) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exercises By Type Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-yellow-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Exercise Types</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ count($exercisesByType) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Overview Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- User Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Users Overview</h3>
                    <div class="h-80">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Registrations</h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recentUsers as $user)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-500">
                                                    {{ substr($user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                        </div>
                                        <div>
                                            @if($user->created_at >= \Carbon\Carbon::now()->subDays(2))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-gray-500">
                                    No recent registrations
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.users.index') }}"
                           class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-900 bg-white hover:bg-gray-100">
                            View All
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Overview Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Exercise Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Exercise Statistics</h3>

                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-600">Exercise Types</h4>
                        <div class="space-y-2">
                            @foreach($exercisesByType as $type => $count)
                                @php
                                    $typeColors = [
                                        'strength' => 'bg-blue-500',
                                        'cardio' => 'bg-red-500',
                                        'flexibility' => 'bg-green-500',
                                        'balance' => 'bg-yellow-500',
                                        'plyometric' => 'bg-purple-500',
                                        'functional' => 'bg-indigo-500',
                                    ];
                                    $barColor = $typeColors[$type] ?? 'bg-gray-500';
                                    $percentage = ($count / $totalExercises) * 100;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ \Illuminate\Support\Str::title($type) }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ ($barColor) }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <h4 class="text-sm font-medium text-gray-600 mt-6">Difficulty Levels</h4>
                        <div class="space-y-2">
                            @foreach($exercisesByDifficulty as $difficulty => $count)
                                @php
                                    $difficultyColors = [
                                        'beginner' => 'bg-green-500',
                                        'intermediate' => 'bg-yellow-500',
                                        'advanced' => 'bg-red-500',
                                    ];
                                    $barColor = $difficultyColors[$difficulty] ?? 'bg-gray-500';
                                    $percentage = ($count / $totalExercises) * 100;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ \Illuminate\Support\Str::title($difficulty) }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Meal Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Meal Statistics</h3>

                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-600">Meal Categories</h4>
                        <div class="space-y-2">
                            @foreach($mealsByType as $type => $count)
                                @php
                                    $typeColors = [
                                        'breakfast' => 'bg-yellow-500',
                                        'lunch' => 'bg-green-500',
                                        'dinner' => 'bg-purple-500',
                                        'snack' => 'bg-blue-500',
                                    ];
                                    $barColor = $typeColors[$type] ?? 'bg-gray-500';
                                    $percentage = ($count / $totalMeals) * 100;
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ \Illuminate\Support\Str::title($type) }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Average Calories per Meal</h4>
                            <div class="flex items-end space-x-2">
                                <span class="text-3xl font-bold text-gray-900">{{ $avgCaloriesPerMeal }}</span>
                                <span class="text-sm text-gray-500 pb-1">calories</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            View All
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        @forelse($recentActivities as $activity)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-{{ $activity['icon_color'] }}-100 flex items-center justify-center">
                                                @if($activity['type'] === 'user_registration')
                                                    <svg class="h-6 w-6 text-{{ $activity['icon_color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                @elseif($activity['type'] === 'meal_created')
                                                    <svg class="h-6 w-6 text-{{ $activity['icon_color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                @elseif($activity['type'] === 'exercise_created')
                                                    <svg class="h-6 w-6 text-{{ $activity['icon_color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <span class="text-sm text-gray-500">{{ $activity['time']->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                                No recent activities found
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('userRegistrationChart').getContext('2d');

            // User registration data from PHP
            const labels = @json($userRegistrationData['labels']);
            const data = @json($userRegistrationData['counts']);

            const gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
            gradientFill.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradientFill.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'New Registrations',
                        data: data,
                        borderColor: 'rgba(79, 70, 229, 1)',
                        backgroundColor: gradientFill,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleColor: '#fff',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#9CA3AF'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 11
                                },
                                color: '#9CA3AF'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
