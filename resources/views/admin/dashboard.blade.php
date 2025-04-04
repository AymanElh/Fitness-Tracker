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
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">3,724</h3>
                                    <span class="ml-2 text-sm font-medium text-green-600">+12%</span>
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
                                <p class="text-sm font-medium text-gray-600">Active Plans</p>
                                <div class="flex items-baseline">
                                    <h3 class="text-2xl font-bold text-gray-900 mt-1">2,841</h3>
                                    <span class="ml-2 text-sm font-medium text-green-600">+8%</span>
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
                                <p class="text-sm font-medium text-gray-600">Total Exercises</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">256</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Meal Plans Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow-md">
                    <div class="px-5 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-yellow-600 bg-opacity-10 rounded-lg p-3">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Meal Plans</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-1">189</h3>
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
                    <div class="h-80 bg-gray-50 rounded-lg border border-gray-200">
                        <!-- Chart placeholder with gradient background -->
                        <div class="flex items-center justify-center h-full bg-gradient-to-br from-gray-50 to-gray-100">
                            <p class="text-gray-500">Registered Users Chart (last 30 days)</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Registrations</h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-500">JD</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">Jean Dupont</p>
                                        <p class="text-sm text-gray-500 truncate">jeandupont@exemple.com</p>
                                    </div>
                                    <div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                New
                            </span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-500">ML</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">Marie Leclerc</p>
                                        <p class="text-sm text-gray-500 truncate">marieleclerc@exemple.com</p>
                                    </div>
                                    <div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                New
                            </span>
                                    </div>
                                </div>
                            </li>
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-500">PL</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">Paul Louis</p>
                                        <p class="text-sm text-gray-500 truncate">paullouis@exemple.com</p>
                                    </div>
                                    <div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                New
                            </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="#"
                           class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-900 bg-white hover:bg-gray-100">
                            View All
                        </a>
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
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">A new user has signed up</p>
                                        <p class="text-sm text-gray-500">Sophie Martin (sophiemartin@exemple.com)</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="text-sm text-gray-500">5 minutes ago</span>
                                </div>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">New workout plan created</p>
                                        <p class="text-sm text-gray-500">Plan "Strength & Endurance" added to the library</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="text-sm text-gray-500">1 hour ago</span>
                                </div>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">New recipe added</p>
                                        <p class="text-sm text-gray-500">Recipe "Protein-Packed Veggie Bowl" added</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="text-sm text-gray-500">3 hours ago</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
