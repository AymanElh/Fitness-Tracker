@extends('layouts.admin')

@section('title', $exercise->name)

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Exercise Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-5 flex items-center">
                @if($exercise->image_url)
                    <img src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}" class="h-16 w-16 object-cover rounded-full mr-4">
                @else
                    <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                        <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                @endif

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $exercise->name }}</h1>
                    <div class="mt-1 flex items-center">
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

                        @if($exercise->muscle_group)
                            <span class="ml-2 text-sm text-gray-500">{{ \Illuminate\Support\Str::title($exercise->muscle_group) }}</span>
                        @endif
                    </div>
                </div>

                <div class="ml-auto">
                    <a href="{{ route('admin.exercises.edit', $exercise->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                        <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.exercises.destroy', $exercise->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this exercise?')">
                            <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Exercise Details -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <!-- Main Image or Video -->
                <div class="p-6 flex justify-center items-center">
                    @if($exercise->video_url)
                        <div class="aspect-w-16 aspect-h-9 w-full">
                            @php
                                // Extract YouTube video ID
                                $videoId = null;
                                if (strpos($exercise->video_url, 'youtube.com') !== false) {
                                    parse_str(parse_url($exercise->video_url, PHP_URL_QUERY), $params);
                                    $videoId = $params['v'] ?? null;
                                } elseif (strpos($exercise->video_url, 'youtu.be') !== false) {
                                    $videoId = substr(parse_url($exercise->video_url, PHP_URL_PATH), 1);
                                }
                            @endphp

                            @if($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>
                            @else
                                <a href="{{ $exercise->video_url }}" target="_blank" class="block text-center text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-12 w-12 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    View Video Tutorial
                                </a>
                            @endif
                        </div>
                    @elseif($exercise->image_url)
                        <img src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}" class="rounded-lg max-h-64 object-cover">
                    @else
                        <div class="h-48 w-48 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-16 w-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Exercise Info -->
                <div class="md:col-span-2 p-6 grid grid-cols-2 gap-4">
                    <!-- Difficulty -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center border border-gray-200">
                        <div class="text-gray-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-gray-900">Difficulty</div>
                        <div class="text-lg font-bold text-gray-800">{{ \Illuminate\Support\Str::title($exercise->difficulty) }}</div>
                    </div>

                    <!-- Muscle Group -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center border border-gray-200">
                        <div class="text-gray-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-gray-900">Muscle Group</div>
                        <div class="text-lg font-bold text-gray-800">{{ $exercise->muscle_group ? \Illuminate\Support\Str::title($exercise->muscle_group) : 'N/A' }}</div>
                    </div>

                    <!-- Duration -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center border border-gray-200">
                        <div class="text-gray-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-gray-900">Duration</div>
                        <div class="text-lg font-bold text-gray-800">{{ $exercise->duration ? $exercise->duration . ' min' : 'N/A' }}</div>
                    </div>

                    <!-- Calories -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center border border-gray-200">
                        <div class="text-gray-500 mb-1">
                            <svg class="h-6 w-6 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-gray-900">Calories</div>
                        <div class="text-lg font-bold text-gray-800">{{ $exercise->calories_burned ? $exercise->calories_burned . ' cal' : 'N/A' }}</div>
                    </div>

                    <!-- Equipment -->
                    <div class="col-span-2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="text-sm font-medium text-gray-900">Equipment Required</div>
                        </div>
                        <div class="text-gray-800">{{ $exercise->equipment ?: 'None required' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($exercise->description)
            <div class="bg-white shadow rounded-lg mb-6 p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">How to Perform</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($exercise->description)) !!}
                </div>
            </div>
        @endif

        <!-- Related Exercises -->
        @if(count($relatedExercises) > 0)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Related Exercises</h2>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($relatedExercises as $relatedExercise)
                        <a href="{{ route('admin.exercises.show', $relatedExercise->id) }}" class="flex flex-col items-center p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                            @if($relatedExercise->image_url)
                                <img src="{{ $relatedExercise->image_url }}" alt="{{ $relatedExercise->name }}" class="h-24 w-24 object-cover rounded-full mb-3">
                            @else
                                <div class="h-24 w-24 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                    <svg class="h-12 w-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            @endif
                            <h3 class="text-sm font-medium text-gray-900 text-center">{{ $relatedExercise->name }}</h3>
                            <p class="text-xs text-gray-500 text-center mt-1">{{ \Illuminate\Support\Str::title($relatedExercise->type) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.exercises.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Back to List
            </a>
        </div>
    </div>
@endsection
