@extends('layouts.app', ['activePage' => 'exercise-plans'])

@section('title', 'Edit ' . $plan->name . ' - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <a href="{{ route('exercise-plans.index') }}" class="text-gray-400 hover:text-white transition mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold text-white">Edit: {{ $plan->name }}</h1>
                </div>

                <div class="flex items-center">
                    <a href="{{ route('exercise-plans.show', $plan) }}" class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-2 px-4 rounded-lg mr-3 transition">
                        <i class="fas fa-eye mr-2"></i> View Plan
                    </a>

                    <form action="{{ route('exercise-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 py-2 px-4 rounded-lg transition">
                            <i class="fas fa-trash mr-2"></i> Delete Plan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Plan Details Form -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <div class="lg:col-span-1">
                    <div class="bg-slate-800 rounded-xl p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-white mb-4">Plan Details</h2>

                        <form action="{{ route('exercise-plans.update', $plan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name" class="block text-gray-300 mb-2">Plan Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $plan->name) }}"
                                       class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-300 mb-2">Description</label>
                                <textarea id="description" name="description" rows="3"
                                          class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">{{ old('description', $plan->description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="level" class="block text-gray-300 mb-2">Difficulty Level</label>
                                <select id="level" name="level"
                                        class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                    <option value="beginner" {{ $plan->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ $plan->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ $plan->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="duration_weeks" class="block text-gray-300 mb-2">Duration (Weeks)</label>
                                <input type="number" id="duration_weeks" name="duration_weeks" min="1" max="52"
                                       value="{{ old('duration_weeks', $plan->duration_weeks) }}"
                                       class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                            </div>

                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input type="checkbox" value="1" name="is_public" {{ $plan->is_public ? 'checked' : '' }}
                                    class="form-checkbox bg-slate-700 border-slate-600 rounded text-blue-500 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-300">Make this plan public</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <!-- Add Workout Day Form -->
                    <div class="bg-slate-800 rounded-xl p-6 mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Add Workout Day</h2>

                        <form action="{{ route('exercise-plans.days.store', $plan) }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="day_name" class="block text-gray-300 mb-2">Day Name</label>
                                    <input type="text" id="day_name" name="name"
                                           class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                           placeholder="E.g., Upper Body Day, Leg Day" required>
                                </div>

                                <div class="flex items-center">
                                    <label class="flex items-center h-full pt-8">
                                        <input type="checkbox" name="is_rest_day"
                                               class="form-checkbox bg-slate-700 border-slate-600 rounded text-blue-500 focus:ring-blue-500">
                                        <span class="ml-2 text-gray-300">Rest Day</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="day_notes" class="block text-gray-300 mb-2">Notes (Optional)</label>
                                <textarea id="day_notes" name="notes" rows="2"
                                          class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                          placeholder="Additional instructions or notes for this workout day"></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition">
                                    <i class="fas fa-plus mr-2"></i> Add Day
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Workout Days List -->
                    <div class="space-y-6">
                        @forelse($plan->days as $day)
                            <div class="bg-slate-800 rounded-xl overflow-hidden">
                                <div class="bg-slate-700 p-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                    <span class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3">
                                        {{ $day->day_number }}
                                    </span>
                                        <h3 class="text-lg font-semibold text-white">{{ $day->name }}</h3>
                                        @if($day->is_rest_day)
                                            <span class="ml-3 px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">
                                            Rest Day
                                        </span>
                                        @endif
                                    </div>

                                    <div class="flex space-x-2">
                                        <button type="button" onclick="toggleDay('day-{{ $day->id }}')" class="text-gray-400 hover:text-white transition">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>

                                        <form action="{{ route('exercise-plans.days.destroy', $day) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this day?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div id="day-{{ $day->id }}" class="p-6">
                                    <!-- Day Edit Form -->
                                    <form action="{{ route('exercise-plans.days.update', $day) }}" method="POST" class="mb-6 bg-slate-700/50 p-4 rounded-lg">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="edit_day_name_{{ $day->id }}" class="block text-gray-300 mb-2">Day Name</label>
                                                <input type="text" id="edit_day_name_{{ $day->id }}" name="name" value="{{ $day->name }}"
                                                       class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                                       required>
                                            </div>

                                            <div class="flex items-center">
                                                <label class="flex items-center h-full pt-8">
                                                    <input type="checkbox" name="is_rest_day" {{ $day->is_rest_day ? 'checked' : '' }}
                                                    class="form-checkbox bg-slate-700 border-slate-600 rounded text-blue-500 focus:ring-blue-500">
                                                    <span class="ml-2 text-gray-300">Rest Day</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="edit_day_notes_{{ $day->id }}" class="block text-gray-300 mb-2">Notes</label>
                                            <textarea id="edit_day_notes_{{ $day->id }}" name="notes" rows="2"
                                                      class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">{{ $day->notes }}</textarea>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm transition">
                                                <i class="fas fa-save mr-2"></i> Update Day
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Exercise List for this Day -->
                                    @if(!$day->is_rest_day)
                                        <div class="mb-6">
                                            <h4 class="text-lg font-semibold text-white mb-4">Exercises</h4>

                                            @if($day->exercises->count() > 0)
                                                <div class="space-y-3 mb-6">
                                                    @foreach($day->exercises as $item)
                                                        <div class="bg-slate-700/50 p-4 rounded-lg">
                                                            <div class="flex justify-between">
                                                                <div class="flex items-center">
                                                                <span class="bg-blue-500/20 text-blue-400 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3">
                                                                    {{ $loop->iteration }}
                                                                </span>
                                                                    <div>
                                                                        <h5 class="font-medium text-white">{{ $item->exercise->name }}</h5>
                                                                        <p class="text-gray-400 text-sm">
                                                                            @if($item->sets && $item->reps)
                                                                                {{ $item->sets }} sets × {{ $item->reps }} reps
                                                                            @elseif($item->duration)
                                                                                {{ $item->duration }}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-center space-x-2">
                                                                    <button type="button" onclick="toggleExercise('exercise-{{ $item->id }}')" class="text-gray-400 hover:text-white transition">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>

                                                                    <form action="{{ route('exercise-plans.exercises.destroy', $item) }}" method="POST"
                                                                          onsubmit="return confirm('Remove this exercise?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <!-- Exercise Edit Form -->
                                                            <div id="exercise-{{ $item->id }}" class="hidden mt-4 pt-4 border-t border-slate-600">
                                                                <form action="{{ route('exercise-plans.exercises.update', $item) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                                        <div>
                                                                            <label class="block text-gray-300 mb-2">Sets</label>
                                                                            <input type="number" name="sets" value="{{ $item->sets }}" min="1"
                                                                                   class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2 text-white focus:border-blue-500 focus:outline-none">
                                                                        </div>

                                                                        <div>
                                                                            <label class="block text-gray-300 mb-2">Reps</label>
                                                                            <input type="number" name="reps" value="{{ $item->reps }}" min="1"
                                                                                   class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2 text-white focus:border-blue-500 focus:outline-none">
                                                                        </div>

                                                                        <div>
                                                                            <label class="block text-gray-300 mb-2">Duration</label>
                                                                            <input type="text" name="duration" value="{{ $item->duration }}"
                                                                                   placeholder="e.g., 30 sec, 2 min"
                                                                                   class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2 text-white focus:border-blue-500 focus:outline-none">
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-4">
                                                                        <label class="block text-gray-300 mb-2">Notes</label>
                                                                        <textarea name="notes" rows="2"
                                                                                  class="w-full bg-slate-700 border border-slate-600 rounded-lg p-2 text-white focus:border-blue-500 focus:outline-none"
                                                                                  placeholder="Instructions or modifications">{{ $item->notes }}</textarea>
                                                                    </div>

                                                                    <div class="flex justify-end">
                                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg text-sm transition">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="bg-slate-700/30 p-4 rounded-lg text-center">
                                                    <p class="text-gray-400">No exercises added yet. Add your first exercise below.</p>
                                                </div>
                                            @endif

                                            <!-- Add Exercise Form -->
                                            <form action="{{ route('exercise-plans.exercises.store', $day) }}" method="POST" class="bg-slate-700/50 p-4 rounded-lg mt-4">
                                                @csrf

                                                <div class="mb-4">
                                                    <label for="exercise_id_{{ $day->id }}" class="block text-gray-300 mb-2">Select Exercise</label>
                                                    <select id="exercise_id_{{ $day->id }}" name="exercise_id"
                                                            class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                                            required>
                                                        <option value="">-- Select an exercise --</option>
                                                        @foreach($exercises as $exercise)
                                                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                    <div>
                                                        <label for="sets_{{ $day->id }}" class="block text-gray-300 mb-2">Sets</label>
                                                        <input type="number" id="sets_{{ $day->id }}" name="sets" min="1" value="3"
                                                               class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                                    </div>

                                                    <div>
                                                        <label for="reps_{{ $day->id }}" class="block text-gray-300 mb-2">Reps</label>
                                                        <input type="number" id="reps_{{ $day->id }}" name="reps" min="1" value="10"
                                                               class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                                    </div>

                                                    <div>
                                                        <label for="duration_{{ $day->id }}" class="block text-gray-300 mb-2">Duration</label>
                                                        <input type="text" id="duration_{{ $day->id }}" name="duration"
                                                               placeholder="e.g., 30 sec, 2 min"
                                                               class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none">
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="notes_{{ $day->id }}" class="block text-gray-300 mb-2">Notes</label>
                                                    <textarea id="notes_{{ $day->id }}" name="notes" rows="2"
                                                              class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:border-blue-500 focus:outline-none"
                                                              placeholder="Instructions or modifications"></textarea>
                                                </div>

                                                <div class="flex justify-end">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition">
                                                        <i class="fas fa-plus mr-2"></i> Add Exercise
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="bg-green-500/10 text-green-400 p-4 rounded-lg mb-6">
                                            <i class="fas fa-bed mr-2"></i> This is a rest day. No exercises needed.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-slate-800 rounded-xl p-8 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-500/20 text-blue-400 rounded-full">
                                    <i class="fas fa-calendar-day text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-white mb-2">No Workout Days Yet</h3>
                                <p class="text-gray-400 mb-6">Add your first workout day to start building your plan!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        function toggleDay(id) {
            const element = document.getElementById(id);
            if (element.style.display === 'none') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }

        function toggleExercise(id) {
            const element = document.getElementById(id);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
@endsection
