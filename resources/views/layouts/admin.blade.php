<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Administration Fitness</title>
    <meta name="description" content="Tableau de bord d'administration pour l'application de fitness et nutrition">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    fontSize: {
                        'xs': ['0.75rem', {lineHeight: '1rem'}],
                        'sm': ['0.875rem', {lineHeight: '1.25rem'}],
                        'base': ['1rem', {lineHeight: '1.5rem'}],
                        'lg': ['1.125rem', {lineHeight: '1.75rem'}],
                        'xl': ['1.25rem', {lineHeight: '1.75rem'}],
                        '2xl': ['1.5rem', {lineHeight: '2rem'}],
                        '3xl': ['1.875rem', {lineHeight: '2.25rem'}],
                    },
                }
            }
        }
    </script>

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
</body>
</html>
