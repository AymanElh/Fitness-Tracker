<x-auth-layout>
    <x-slot:title>Login | FitTrack</x-slot>

    <x-slot:styles>
        <style>
            .form-input-focus:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            }

            input {
                background-color: rgba(30, 41, 59, 0.8);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
            }

            input::placeholder {
                color: rgba(255, 255, 255, 0.5);
            }

            input:focus {
                border-color: #3b82f6;
                background-color: rgba(30, 41, 59, 0.9);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
        </style>
    </x-slot:styles>

    <div class="w-full login-container mx-auto space-y-6 sm:space-y-8 fade-in">
        <!-- Header -->
        <div class="text-center login-header">
            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-bold text-white tracking-tight">
                Welcome Back
            </h2>
            <p class="mt-2 sm:mt-3 text-sm sm:text-base text-gray-400">
                Start your fitness journey today or
                <a href="{{ route('register') }}"
                   class="font-medium gradient-text hover:opacity-90 transition-colors duration-300">
                    create a new account
                </a>
            </p>
        </div>

        <!-- Social Login Buttons -->
        <div class="space-y-3 pt-2 social-buttons sm:space-y-3">
            {{--            <button class="w-full flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all duration-300">--}}
            {{--                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" viewBox="0 0 24 24">--}}
            {{--                    <path fill="#4285F4" d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>--}}
            {{--                </svg>--}}
            {{--                <span class="text-sm sm:text-base">Continue with Google</span>--}}
            {{--            </button>--}}

            {{--            <button class="w-full flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm bg-[#1877F2] text-sm font-medium text-white hover:bg-[#166FE5] transition-all duration-300">--}}
            {{--                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="currentColor" viewBox="0 0 24 24">--}}
            {{--                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>--}}
            {{--                </svg>--}}
            {{--                <span class="text-sm sm:text-base">Continue with Facebook</span>--}}
            {{--            </button>--}}
        </div>

        <div class="relative my-5 sm:my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 sm:px-4 bg-slate-900 text-gray-400 text-xs sm:text-sm font-medium">
                    Or sign in with email
                </span>
            </div>
        </div>

        <!-- Login Form -->
        <form class="space-y-5 sm:space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4 sm:space-y-5">
                <div>
                    <label for="email" class="text-sm font-medium text-gray-300 mb-1 block">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="you@example.com"
                        required
                        value="{{ old('email') }}"
                        class="block w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm focus:outline-none transition-all duration-300 text-sm sm:text-base"
                    />
                    @error('email')
                    <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex flex-wrap justify-between items-center mb-1">
                        <label for="password" class="text-sm font-medium text-gray-300 block">Password</label>
                        <a href=""
                           class="text-xs sm:text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors duration-300 mt-0.5 sm:mt-0">
                            Forgot password?
                        </a>
                    </div>
                    <div class="form-input-focus rounded-lg transition duration-300">
                        <input
                            name="password"
                            id="password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="block w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm focus:outline-none transition-all duration-300 text-sm sm:text-base"
                            required
                        />
                    </div>
                    @error('password')
                    <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between pt-1 sm:pt-2">
                <div class="flex items-center">
                    <input
                        id="remember_me"
                        name="remember_me"
                        type="checkbox"
                        class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label class="ml-2 sm:ml-3 block text-xs sm:text-sm text-gray-400" for="remember_me">
                        Remember me
                    </label>
                </div>
            </div>

            <div class="pt-3 sm:pt-4">
                <button
                    type="submit"
                    class="animated-button btn-primary w-full flex justify-center items-center py-2.5 sm:py-3 px-3 sm:px-4 border border-transparent rounded-lg shadow-sm text-sm sm:text-base font-medium text-white transition-all duration-300"
                >
                    <span>Sign in</span>
                    <svg class="ml-1.5 sm:ml-2 h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="text-center mt-5 sm:mt-6">
            <p class="text-xs sm:text-sm text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="font-medium gradient-text hover:opacity-90 transition-colors duration-300">
                    Sign up now
                </a>
            </p>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Focus the email field on page load if not on mobile
                if (window.innerWidth > 768) {
                    document.getElementById('email').focus();
                }

                // Add floating label effect
                const inputs = document.querySelectorAll('input:not([type="checkbox"])');
                inputs.forEach(input => {
                    input.addEventListener('focus', () => {
                        input.classList.add('ring-1');
                        input.classList.add('ring-blue-500');
                    });

                    input.addEventListener('blur', () => {
                        input.classList.remove('ring-1');
                        input.classList.remove('ring-blue-500');
                    });
                });

                // Adjust layout for orientation changes
                window.addEventListener('resize', function () {
                    // Additional responsive adjustments can be added here if needed
                });

                // Detect viewport height for better mobile experience
                function adjustForViewport() {
                    const vh = window.innerHeight * 0.01;
                    document.documentElement.style.setProperty('--vh', `${vh}px`);
                }

                // Initial call and event listener for resize
                adjustForViewport();
                window.addEventListener('resize', adjustForViewport);
            });
        </script>
    </x-slot:scripts>
</x-auth-layout>
