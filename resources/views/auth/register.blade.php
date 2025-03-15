<x-auth-layout>
    <x-slot:title>Sign Up</x-slot>

    <x-slot:styles>
        <style>
            /* Base styles */
            .form-input-focus:focus-within {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            }

            .animated-button {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .animated-button:after {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                width: 300%;
                height: 300%;
                background: rgba(255, 255, 255, 0.1);
                transform: translate(-50%, -50%) scale(0);
                border-radius: 50%;
                transition: transform 0.6s ease;
            }

            .animated-button:hover:after {
                transform: translate(-50%, -50%) scale(1);
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .fade-in {
                animation: fadeIn 0.5s ease forwards;
            }

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .login-container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                    width: 100%;
                }

                .login-header h2 {
                    font-size: 1.75rem;
                }

                .social-buttons {
                    flex-direction: column;
                    gap: 0.75rem;
                }
            }

            @media (min-width: 641px) and (max-width: 1023px) {
                .login-container {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                    width: 90%;
                    max-width: 28rem;
                }
            }

            @media (min-width: 1024px) {
                .login-container {
                    padding-left: 2rem;
                    padding-right: 2rem;
                    width: 100%;
                    max-width: 32rem;
                }
            }
        </style>
    </x-slot:styles>

    <div class="w-full max-w-md space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Sign in here
                </a>
            </p>
        </div>

        <!-- Social Signup Button -->
        <div class="space-y-3">
            <button class="w-full flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                </svg>
                <span class="text-sm sm:text-base">Continue with Google</span>
            </button>
        </div>

        <button class="w-full flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg shadow-sm bg-[#1877F2] text-sm font-medium text-white hover:bg-[#166FE5] transition-all duration-300">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span class="text-sm sm:text-base">Continue with Facebook</span>
        </button>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-50 text-gray-500">
                    Or sign up with email
                </span>
            </div>
        </div>

        <!-- Register Form -->
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <!-- Full Name -->
                <div>
                    <x-form.form-label for="name">Full Name</x-form.form-label>
                    <x-form.form-input id="name" name="name" placeholder="John Doe" />
                    <x-form.form-error name="name" />
                </div>

                <!-- Email -->
                <div>
                    <x-form.form-label for="email">Email</x-form.form-label>
                    <x-form.form-input id="email" name="email" placeholder="username@example.com" />
                    <x-form.form-error name="email" />
                </div>

                <!-- Password -->
                <div>
                    <x-form.form-label for="password">Password</x-form.form-label>
                    <x-form.form-input id="password" name="password" placeholder="*******" />
                    <x-form.form-error name="password" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-form.form-label for="password_confirmation">Confirm Password</x-form.form-label>
                    <x-form.form-input id="password_confirmation" name="password_confirmation" placeholder="******" />
                    <x-form.form-error name="password_confirmation" />
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <x-form.button>Create Account</x-form.button>

            </div>
        </form>
    </div>
</x-auth-layout>
