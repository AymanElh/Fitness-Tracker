<x-auth-layout>

    <x-slot:title>Forgot Password</x-slot:title>

    <!-- Flash Messages Section -->
{{--    <div class="flash-messages">--}}
{{--        @if (session('status'))--}}
{{--            <div class="rounded-md bg-green-50 p-4 mb-4">--}}
{{--                <div class="flex">--}}
{{--                    <div class="flex-shrink-0">--}}
{{--                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">--}}
{{--                        <p class="text-sm font-medium text-green-800">--}}
{{--                            {{ session('status') }}--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if (session('error'))--}}
{{--            <div class="rounded-md bg-red-50 p-4 mb-4">--}}
{{--                <div class="flex">--}}
{{--                    <div class="flex-shrink-0">--}}
{{--                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">--}}
{{--                        <p class="text-sm font-medium text-red-800">--}}
{{--                            {{ session('error') }}--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if (session('info'))--}}
{{--            <div class="rounded-md bg-blue-50 p-4 mb-4">--}}
{{--                <div class="flex">--}}
{{--                    <div class="flex-shrink-0">--}}
{{--                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                    <div class="ml-3">--}}
{{--                        <p class="text-sm font-medium text-blue-800">--}}
{{--                            {{ session('info') }}--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}

    <div class="w-full max-w-md space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Forgot your password?
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        <!-- Reset Password Form -->
        <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
            @csrf

            <!-- Success Message -->
            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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

            <div class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                               placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500
                               sm:text-sm transition-colors @error('email') border-red-500 @enderror"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <x-form.button>Send Reset Link</x-form.button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Back to login
                </a>
            </div>
        </form>
    </div>
</x-auth-layout>
