<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FitnessTracker' }}</title>
    @vite(['resources/css/app.css'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{ $styles ?? '' }}
</head>
<body class="h-full bg-gray-50">
<div class="min-h-screen flex">
    <!-- Left Side - Image -->
    <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
        <div class="w-full flex items-center justify-center bg-black bg-opacity-40">
            <div class="text-center text-white px-8">
                <h1 class="text-4xl font-bold mb-4">FitnessTracker</h1>
                <p class="text-xl">Transform your life with our fitness application</p>
            </div>
        </div>
    </div>

    <!-- Right Side - Auth Content -->
    <div class="flex flex-col justify-center w-full lg:w-1/2 px-4 sm:px-6 lg:px-8">
        <!-- Logo for mobile -->
        <div class="lg:hidden text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">FitnessTracker</h1>
        </div>

        <!-- Auth Content -->
        <div class="max-w-md w-full mx-auto">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} FitnessTracker. All rights reserved.</p>
        </div>
    </div>
</div>

<!-- Flash Messages -->
@if (session('success') || session('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50">
        @if (session('success'))
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

{{ $scripts ?? '' }}
</body>
</html>
