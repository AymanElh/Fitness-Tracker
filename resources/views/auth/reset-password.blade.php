<x-auth-layout>
    <x-slot:title>Reset Password</x-slot>

    <div class="w-full max-w-md space-y-8">
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
        <form class="mt-8 space-y-6" action="#" method="POST">
            @csrf

            <!-- Hidden Token Field -->
            {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

            <div class="space-y-5">
                <!-- Email -->
                <div>
                    <x-form.form-label for="email">Email</x-form.form-label>
                    <x-form.form-input type="email" id="email" name="email" placeholder="••••••••" />
                    <x-form.form-error name="password_confirmation" />
                </div>

                <!-- New Password -->
                <div>
                    <x-form.form-label for="password">Password</x-form.form-label>
                    <x-form.form-input type="password" id="password" name="password" placeholder="••••••••" />
                    <x-form.form-error name="password" />
                </div>

                <!-- Confirm New Password -->
                <div>
                    <x-form.form-label for="password_confirmation">Confirm Password</x-form.form-label>
                    <x-form.form-input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" />
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
                <x-form.button>Reset Password</x-form.button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Back to login
                </a>
            </div>
        </form>
    </div>
</x-auth-layout>
