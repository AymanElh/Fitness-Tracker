@props(['activePage' => ''])

<!-- Fixed Navigation Header -->
<header class="fixed top-0 left-0 right-0 z-50 bg-slate-900/90 backdrop-blur-md py-4 shadow-lg">
    <div class="container mx-auto px-4">
        <nav class="flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold gradient-text">
                <i class="fas fa-heartbeat mr-2"></i> FitTrack
            </a>

            <!-- Navigation Links - Center -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Home -->
                <a href="{{ route('home') }}"
                   class="text-white transition {{ $activePage === 'home' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                    Home
                </a>

                <!-- Exercises -->
                <a href="{{ route('exercises.index') }}"
                   class="text-white transition {{ $activePage === 'exercises' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                    Exercises
                </a>

                <!-- Foods -->
                <a href="{{ route('foods.index') }}"
                   class="text-white transition {{ $activePage === 'foods' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                    Foods
                </a>

                <!-- Meals -->
                <a href="{{ route('meals.index') }}"
                   class="text-white transition {{ $activePage === 'meals' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                    Meals
                </a>

                @auth
                    <!-- Exercise Plans -->
                    <a href="{{ route('exercise-plans.index') }}"
                       class="text-white transition {{ $activePage === 'exercise-plans' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                        Exercise Plans
                    </a>

                    <!-- Nutrition Plans -->
                    <a href="{{ route('nutrition-plans.index') }}"
                       class="text-white transition {{ $activePage === 'nutrition-plans' ? 'text-blue-400 font-medium border-b-2 border-blue-400 pb-1' : 'hover:text-blue-400' }}">
                        Nutrition Plans
                    </a>
                @endauth
            </div>

            <!-- Auth Buttons / User Profile - Right -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                       class="text-white transition {{ $activePage === 'login' ? 'text-blue-400 font-medium' : 'hover:text-blue-400' }}">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="{{ $activePage === 'register' ? 'bg-blue-700' : 'bg-blue-600 hover:bg-blue-700' }} py-2 px-4 rounded-lg text-white transition">
                        Register
                    </a>
                @else
                    <!-- User Profile Dropdown -->
                    <div class="relative profile-dropdown">
                        <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-10 w-10 rounded-full object-cover border-2 {{ $activePage === 'profile' ? 'border-blue-400' : 'border-blue-500' }}">
                            <span class="text-white hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-lg py-2 z-10 hidden">
                            <div class="px-4 py-2 border-b border-slate-700">
                                <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-gray-400 text-sm truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.show') }}"
                               class="block px-4 py-2 text-white hover:bg-slate-700 transition {{ $activePage === 'profile' ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-user mr-2"></i> Your Profile
                            </a>
                            <a href="{{ route('nutrition-plans.index') }}"
                               class="block px-4 py-2 text-white hover:bg-slate-700 transition {{ $activePage === 'nutrition-plans' ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-utensils mr-2"></i> Your Nutrition Plans
                            </a>
                            <a href="{{ route('exercise-plans.index') }}"
                               class="block px-4 py-2 text-white hover:bg-slate-700 transition {{ $activePage === 'exercise-plans' ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-dumbbell mr-2"></i> Your Exercise Plans
                            </a>
                            <div class="border-t border-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-white hover:bg-slate-700 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>
    </div>
</header>


