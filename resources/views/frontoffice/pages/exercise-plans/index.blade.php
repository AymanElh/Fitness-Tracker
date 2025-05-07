@extends('layouts.app', ['activePage' => 'exercise-plans'])

@section('title', 'My Exercise Plans - FitTrack')

@section('content')
    <section class="pt-32 pb-16 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">My Exercise Plans</h1>
                    <p class="text-gray-400">Create and manage your custom workout routines</p>
                </div>
                <a href="{{ route('exercise-plans.create') }}"
                   class="btn-primary py-2 px-6 rounded-full text-white flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create New Plan
                </a>
            </div>

            <!-- User's Plans -->
            @if($plans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                    @foreach($plans as $plan)
                        <div
                            class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-blue-500/30 transition duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $plan->level_badge }}">
                                    {{ ucfirst($plan->level) }}
                                </span>
                                </div>

                                <p class="text-gray-400 mb-6 line-clamp-2">{{ $plan->description ?: 'No description provided' }}</p>

                                <div class="flex items-center mb-6">
                                    <div class="flex items-center mr-6">
                                        <i class="fas fa-calendar-alt text-blue-400 mr-2"></i>
                                        <span class="text-gray-300">{{ $plan->duration_weeks }} weeks</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-dumbbell text-blue-400 mr-2"></i>
                                        <span class="text-gray-300">{{ $plan->days->count() }} days</span>
                                    </div>
                                </div>

                                <div class="flex space-x-3">
                                    <a href="{{ route('exercise-plans.show', $plan) }}"
                                       class="flex-1 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 py-2 rounded-lg text-center transition">
                                        <i class="fas fa-eye mr-2"></i> View
                                    </a>
                                    <a href="{{ route('exercise-plans.edit', $plan) }}"
                                       class="flex-1 bg-white/10 hover:bg-white/20 text-white py-2 rounded-lg text-center transition">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    <button
                                        onclick="confirmDelete('{{ $plan->id }}', '{{ $plan->name }}')"
                                        class="flex-1 bg-red-500/20 hover:bg-red-500/30 text-red-400 py-2 rounded-lg text-center transition">
                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                    </button>
                                </div>
                                <form id="delete-form-{{ $plan->id }}" method="post"
                                      action="{{ route('exercise-plans.destroy', $plan) }}" class="hidden">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-800/50 rounded-lg p-8 text-center mb-16">
                    <div
                        class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-500/20 text-blue-400 rounded-full">
                        <i class="fas fa-dumbbell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No Exercise Plans Yet</h3>
                    <p class="text-gray-400 mb-6">Create your first workout plan to get started!</p>
                    <a href="{{ route('exercise-plans.create') }}"
                       class="btn-primary py-3 px-8 rounded-full text-white inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create New Plan
                    </a>
                </div>
            @endif

            <!-- Community Plans -->
            @if($publicPlans->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Community Exercise Plans</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($publicPlans as $plan)
                            <div
                                class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-purple-500/30 transition duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $plan->level_badge }}">
                                        {{ ucfirst($plan->level) }}
                                    </span>
                                    </div>

                                    <p class="text-gray-400 mb-4 line-clamp-2">{{ $plan->description ?: 'No description provided' }}</p>

                                    <div class="flex items-center mb-2">
                                        <img
                                            src="https://ui-avatars.com/api/?name={{ urlencode($plan->user->name) }}&background=random"
                                            alt="User avatar"
                                            class="w-6 h-6 rounded-full mr-2">
                                        <span class="text-gray-300 text-sm">Created by {{ $plan->user->name }}</span>
                                    </div>

                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center mr-6">
                                            <i class="fas fa-calendar-alt text-purple-400 mr-2"></i>
                                            <span class="text-gray-300">{{ $plan->duration_weeks }} weeks</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-dumbbell text-purple-400 mr-2"></i>
                                            <span class="text-gray-300">{{ $plan->days->count() }} days</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('exercise-plans.show', $plan) }}"
                                       class="w-full bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 py-2 rounded-lg text-center block transition">
                                        <i class="fas fa-eye mr-2"></i> View Plan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Add this to your page's script section or include in a JS file
        function confirmDelete(planId, planName) {
            // Create modal backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-slate-900/80 flex items-center justify-center z-50';
            document.body.appendChild(backdrop);

            // Create modal content
            backdrop.innerHTML = `
                <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 max-w-md w-full mx-4 transform transition-all">
                    <h3 class="text-xl font-bold text-white mb-2">Delete Plan</h3>
                    <p class="text-gray-300 mb-6">Are you sure you want to delete "${planName}"? This action cannot be undone.</p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancel-delete" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded">
                            Cancel
                        </button>
                        <button id="confirm-delete" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Delete
                        </button>
                    </div>
                </div>
            `;

            // Add event listeners
            backdrop.querySelector('#cancel-delete').addEventListener('click', () => {
                document.body.removeChild(backdrop);
            });

            backdrop.querySelector('#confirm-delete').addEventListener('click', () => {
                document.getElementById(`delete-form-${planId}`).submit();
            });
        }
    </script>
@endsection
