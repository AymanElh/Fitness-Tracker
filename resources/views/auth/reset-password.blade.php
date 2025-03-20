<x-auth-layout>
    <x-slot:title>Reset Password</x-slot>

    <div class="w-full max-w-md space-y-6">
        <!-- Flash Messages Section -->
        <div class="flash-messages">
            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-md bg-red-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="rounded-md bg-blue-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">
                                {{ session('info') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Header -->
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Reset Your Password
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Create a new strong password for your account
            </p>
        </div>

        <!-- Reset Password Form -->
        <form class="space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf

            <!-- Hidden Token Field -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-5">
                <!-- Email -->
                <div>
                    <x-form.form-label for="email">Email</x-form.form-label>
                    <x-form.form-input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="name@example.com" required autofocus />
                    <x-form.form-error name="email" />
                </div>

                <!-- New Password -->
                <div>
                    <x-form.form-label for="password">New Password</x-form.form-label>
                    <x-form.form-input type="password" id="password" name="password" placeholder="••••••••" required />
                    <x-form.form-error name="password" />
                </div>

                <!-- Confirm New Password -->
                <div>
                    <x-form.form-label for="password_confirmation">Confirm Password</x-form.form-label>
                    <x-form.form-input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required />
                    <x-form.form-error name="password_confirmation" />
                </div>

                <!-- Password Requirements -->
                <div class="rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Password requirements:</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Minimum 8 characters</li>
                                    <li>At least one uppercase letter</li>
                                    <li>At least one number</li>
                                    <li>At least one special character</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <x-form.button class="w-full">Reset Password</x-form.button>
            </div>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Back to login
                </a>
            </div>
        </form>
    </div>
</x-auth-layout>
