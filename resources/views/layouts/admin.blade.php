<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - Administration Fitness</title>
    <meta name="description" content="Tableau de bord d'administration pour l'application de fitness et nutrition">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])

    @yield('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Smooth scrolling and better text rendering */
        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Better focus outline */
        *:focus {
            outline: 2px solid rgba(59, 130, 246, 0.5);
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-base antialiased">
<div class="flex h-screen overflow-hidden">
    <x-sidebar/>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <main class="py-6">
            @yield('content')
        </main>
    </div>
</div>
@yield('scripts')
</body>
</html>
