<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FitTrack' }}</title>
    @vite(['resources/css/app.css'])

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }

        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
        }

        .card-gradient {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.8));
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .glass-effect {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #8b5cf6;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
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
    </style>

    {{ $styles ?? '' }}
</head>
<body class="h-full">
<div class="min-h-screen flex">
    <!-- Left Side - Image with Overlay -->
    <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/70"></div>
        <div class="w-full h-full flex items-center justify-center relative z-10">
            <div class="text-center text-white px-8">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-heartbeat text-blue-500 text-4xl mr-2"></i>
                    <h1 class="text-4xl font-bold"><span class="gradient-text">FitTrack</span></h1>
                </div>
                <p class="text-xl text-gray-300">Transform your body, track your progress</p>
                <div class="mt-8 max-w-md mx-auto">
                    <div class="bg-white/10 backdrop-blur-md border border-white/5 p-6 rounded-xl">
                        <p class="italic text-gray-300 mb-4">"The FitTrack app has completely transformed my approach to fitness. The tracking tools and nutrition guidance are exactly what I needed."</p>
                        <div class="flex items-center justify-center">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Testimonial" class="w-10 h-10 rounded-full border-2 border-blue-500">
                            <div class="ml-3 text-left">
                                <p class="text-sm font-medium">Sarah Johnson</p>
                                <div class="flex text-yellow-400 mt-1">
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star-half-alt text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Auth Content -->
    <div class="flex flex-col justify-center w-full lg:w-1/2 px-4 sm:px-6 lg:px-8 bg-slate-900">
        <!-- Logo for mobile -->
        <div class="lg:hidden text-center mb-8">
            <div class="flex items-center justify-center">
                <i class="fas fa-heartbeat text-blue-500 text-3xl mr-2"></i>
                <h1 class="text-3xl font-bold"><span class="gradient-text">FitTrack</span></h1>
            </div>
        </div>

        <!-- Auth Content -->
        <div class="max-w-md w-full mx-auto">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} FitTrack. All rights reserved.</p>
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
