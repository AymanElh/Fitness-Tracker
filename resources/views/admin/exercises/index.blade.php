@extends('layouts.admin')

@section('title', 'Exercise Management')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Exercise Management</h1>
            <a href="{{ route('admin.exercises.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Exercise
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Exercises Card -->
            <x-stat-card
                title="Total Exercises"
                value="{{ $totalExercises }}"
                color="blue"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'
            />

            <!-- Exercise Types Card -->
            <x-stat-card
                title="Exercise Types"
{{--                value="{{ count($typeDistribution) }}"--}}
                value=""
                subtitle="categories"
                color="purple"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />'
            />

            <!-- Difficulty Levels Card -->
            <x-stat-card
                title="Difficulty Levels"
{{--                value="{{ array_sum($difficultyDistribution) }}"--}}
                value=""
                subtitle="exercises rated"
                color="yellow"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />'
            />
        </div>

        <!-- Exercises Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Exercises List
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Manage your workout exercises.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Exercise
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Muscle Group
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Difficulty
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($exercises as $exercise)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($exercise->image_url)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $exercise->name }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">
                                            {{ \Illuminate\Support\Str::limit($exercise->description, 60) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'strength' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'cardio' => 'bg-red-100 text-red-800 border-red-200',
                                        'flexibility' => 'bg-green-100 text-green-800 border-green-200',
                                        'balance' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'plyometric' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'functional' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    ];
                                    $typeColor = $typeColors[$exercise->type] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $typeColor }}">
                                {{ \Illuminate\Support\Str::title($exercise->type) }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Illuminate\Support\Str::title($exercise->muscle_group ?? 'N/A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $difficultyColors = [
                                        'beginner' => 'bg-green-100 text-green-800 border-green-200',
                                        'intermediate' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'advanced' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $difficultyColor = $difficultyColors[$exercise->difficulty] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $difficultyColor }}">
                                {{ \Illuminate\Support\Str::title($exercise->difficulty) }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $exercise->duration ? $exercise->duration . ' min' : 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.exercises.show', $exercise->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    View
                                </a>
                                <a href="{{ route('admin.exercises.edit', $exercise->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    Edit
                                </a>
                                <form action="{{ route('admin.exercises.destroy', $exercise->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this exercise?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                No exercises found. Click "Add Exercise" to create your first exercise!
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                {{ $exercises->links() }}
            </div>
        </div>
    </div>
@endsection
