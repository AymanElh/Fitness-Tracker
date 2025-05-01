@extends('layouts.app', ['activePage' => 'home'])

@section('title', 'FitTrack - Your Fitness Companion')

@section('styles')
    <style>
        /* Profile dropdown transitions */
        .profile-dropdown .transform {
            transition-property: opacity, transform;
            transition-duration: 150ms;
        }

        .profile-dropdown .scale-95 {
            transform: scale(0.95);
        }

        .profile-dropdown .scale-100 {
            transform: scale(1);
        }
    </style>
@endsection

@section('content')

    <!-- Header section -->

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 to-slate-900/80 z-10"></div>
            <img
                src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                alt="Fitness tracking background image"
                class="w-full h-full object-cover"
                loading="eager">
        </div>

        <div class="container mx-auto px-4 pt-32 pb-20 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in-element">
                    <span
                        class="px-4 py-2 rounded-full bg-blue-500/10 text-blue-400 text-sm font-semibold inline-block mb-6">
                        FITNESS TRACKING PLATFORM
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight text-shadow">
                        Transform Your Body, <span class="gradient-text">Track Your Progress</span>
                    </h1>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Track your workouts, plan your meals, and achieve your fitness goals with our comprehensive
                        tools.
                    </p>

                    <!-- User Stats - Adds credibility -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-white/10 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold gradient-text">{{ $formattedStats['users'] }}</span>
                            <span class="text-gray-400 text-sm">Active Users</span>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 text-center">
                            <span
                                class="block text-2xl font-bold gradient-text">{{ $formattedStats['exercises'] }}</span>
                            <span class="text-gray-400 text-sm">Exercises</span>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold gradient-text">{{ $formattedStats['foods'] }}</span>
                            <span class="text-gray-400 text-sm">Food Items</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('register') }}"
                               class="btn-primary py-4 px-8 rounded-full text-white font-medium text-lg flex items-center shadow-lg hover:scale-105 transition duration-300">
                                Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <a href="{{ route('nutrition-plans.create') }}"
                               class="btn-primary py-4 px-8 rounded-full text-white font-medium text-lg flex items-center shadow-lg hover:scale-105 transition duration-300">
                                Create Nutrition Plan <i class="fas fa-utensils ml-2"></i>
                            </a>
                        @endguest
                        <a href="#features"
                           class="bg-white/10 hover:bg-white/20 py-4 px-8 rounded-full text-white font-medium text-lg flex items-center border border-white/10 transition duration-300 hover:scale-105">
                            <i class="fas fa-play-circle mr-2"></i> See how it works
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Scroll down indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 hidden md:block">
            <a href="#features"
               class="text-white/70 hover:text-white transition duration-300 animate-bounce flex flex-col items-center">
                <span class="mb-2 text-sm">Scroll Down</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-element">
                <span
                    class="px-4 py-2 rounded-full bg-blue-500/10 text-blue-400 text-sm font-semibold inline-block mb-4">
                    FEATURES
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Everything You Need to <span class="gradient-text">Achieve Your Goals</span>
                </h2>
                <p class="text-gray-400 text-lg">Find exercises and meals that fit your fitness journey and dietary
                    preferences.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-feature-card
                    icon="dumbbell"
                    title="Exercise Library"
                    description="Access a wide range of exercises categorized by muscle groups, difficulty levels, and equipment."
                />

                <x-feature-card
                    icon="utensils"
                    title="Meal Planning"
                    description="Discover healthy meals and create balanced nutrition plans to support your fitness goals."
                />

                <x-feature-card
                    icon="apple-alt"
                    title="Food Database"
                    description="Browse our extensive food database with detailed nutritional information to make informed choices."
                />

                <x-feature-card
                    icon="chart-line"
                    title="Progress Tracking"
                    description="Track your workouts, measurements, and nutritional intake to visualize your progress over time."
                />

                <x-feature-card
                    icon="calendar-alt"
                    title="Workout Scheduling"
                    description="Plan your workout routines with our intuitive calendar system for consistent training."
                />

                <x-feature-card
                    icon="users"
                    title="Community Support"
                    description="Connect with like-minded fitness enthusiasts to stay motivated and share your journey."
                />
            </div>
        </div>
    </section>

    <!-- Exercises Section -->
    <section id="exercises" class="py-24 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-element">
                <h2 class="text-3xl md:text-4xl font-bold mb-6"><span class="gradient-text">Popular Exercises</span> for
                    You</h2>
                <p class="text-gray-400 text-lg">Explore our collection of exercises to build your perfect workout
                    routine.</p>

                <!-- Exercise Category Pills -->
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    <div class="flex flex-wrap justify-center gap-3 mt-6">
                     <span
                         class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition">All</span>
                        <span
                            class="bg-blue-500/20 hover:bg-blue-500/30 px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition">Strength</span>
                        <span
                            class="bg-green-500/20 hover:bg-green-500/30 px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition">Cardio</span>
                        <span
                            class="bg-purple-500/20 hover:bg-purple-500/30 px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition">Flexibility</span>
                        <span
                            class="bg-yellow-500/20 hover:bg-yellow-500/30 px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition">Bodyweight</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exercises as $exercise)
                    <x-exercise-card
                        image="{{ $exercise->image_url ?? 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1769&q=80' }}"
                        name="{{ $exercise->name }}"
                        level="{{ ucfirst($exercise->difficulty) }}"
                        levelClass="bg-{{ $exercise->difficulty === 'beginner' ? 'green' : ($exercise->difficulty === 'intermediate' ? 'yellow' : 'red') }}-500/20 text-{{ $exercise->difficulty === 'beginner' ? 'green' : ($exercise->difficulty === 'intermediate' ? 'yellow' : 'red') }}-400"
                        target="{{ $exercise->muscle_groups ? implode(', ', json_decode($exercise->muscle_groups)) : 'Full Body' }}"
                        duration="{{ $exercise->duration_minutes ?? '15-20' }} mins"
                    />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/exercises') }}"
                   class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center hover:scale-105 transition duration-300">
                    Browse All Exercises <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    {{--    <section class="py-24 bg-slate-900 relative overflow-hidden">--}}
    {{--        <div class="container mx-auto px-4">--}}
    {{--            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-element">--}}
    {{--                <span--}}
    {{--                    class="px-4 py-2 rounded-full bg-blue-500/10 text-blue-400 text-sm font-semibold inline-block mb-4">--}}
    {{--                    SUCCESS STORIES--}}
    {{--                </span>--}}
    {{--                <h2 class="text-3xl md:text-4xl font-bold mb-6">What Our <span--}}
    {{--                        class="gradient-text">Community Says</span></h2>--}}
    {{--                <p class="text-gray-400 text-lg">Real results from real people using FitTrack.</p>--}}
    {{--            </div>--}}

    {{--            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">--}}
    {{--                <div--}}
    {{--                    class="bg-slate-800/50 p-6 rounded-xl border border-white/5 hover:border-blue-500/20 transition duration-300">--}}
    {{--                    <div class="flex items-center mb-4">--}}
    {{--                        <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="User testimonial"--}}
    {{--                             class="w-12 h-12 rounded-full object-cover mr-4">--}}
    {{--                        <div>--}}
    {{--                            <h4 class="font-semibold text-white">Sarah J.</h4>--}}
    {{--                            <p class="text-gray-400 text-sm">Lost 15kg in 6 months</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="text-gray-300 italic">"FitTrack helped me stay consistent with my workouts and meal--}}
    {{--                        planning. The nutrition database made counting macros so much easier!"</p>--}}
    {{--                    <div class="mt-4 text-yellow-400">--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--                <div--}}
    {{--                    class="bg-slate-800/50 p-6 rounded-xl border border-white/5 hover:border-blue-500/20 transition duration-300">--}}
    {{--                    <div class="flex items-center mb-4">--}}
    {{--                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User testimonial"--}}
    {{--                             class="w-12 h-12 rounded-full object-cover mr-4">--}}
    {{--                        <div>--}}
    {{--                            <h4 class="font-semibold text-white">Michael T.</h4>--}}
    {{--                            <p class="text-gray-400 text-sm">Gained 8kg muscle mass</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="text-gray-300 italic">"The exercise library is fantastic! I've discovered so many new--}}
    {{--                        workouts that helped me break through plateaus in my training."</p>--}}
    {{--                    <div class="mt-4 text-yellow-400">--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star-half-alt"></i>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--                <div--}}
    {{--                    class="bg-slate-800/50 p-6 rounded-xl border border-white/5 hover:border-blue-500/20 transition duration-300">--}}
    {{--                    <div class="flex items-center mb-4">--}}
    {{--                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User testimonial"--}}
    {{--                             class="w-12 h-12 rounded-full object-cover mr-4">--}}
    {{--                        <div>--}}
    {{--                            <h4 class="font-semibold text-white">Emily R.</h4>--}}
    {{--                            <p class="text-gray-400 text-sm">Marathon runner</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <p class="text-gray-300 italic">"As a runner, nutrition is crucial. FitTrack's meal plans helped me--}}
    {{--                        fuel properly for my training and improved my race times significantly!"</p>--}}
    {{--                    <div class="mt-4 text-yellow-400">--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                        <i class="fas fa-star"></i>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}


    <!-- Nutrition Section -->
    <section id="nutrition" class="py-24 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-element">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Meal Plans for <span class="gradient-text">Optimal Health</span>
                </h2>
                <p class="text-gray-400 text-lg">Discover balanced meals that fuel your body and support your fitness
                    goals.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($meals as $meal)
                    <x-meal-card
                        image="{{ $meal->image_url ?? 'https://images.unsplash.com/photo-1547592180-85f173990554?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80' }}"
                        name="{{ $meal->name }}"
                        category="{{ $meal->category ?? 'Meal' }}"
                        description="{{ Str::limit($meal->description, 100) }}"
                        calories="{{ $meal->calories ?? '0' }}"
                    />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('nutrition-plans.index') }}"
                   class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center hover:scale-105 transition duration-300">
                    Browse All Meals <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Foods Section -->
    <section id="foods" class="py-24 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-element">
                <h2 class="text-3xl md:text-4xl font-bold mb-6"><span class="gradient-text">Nutritious Foods</span>
                    Database</h2>
                <p class="text-gray-400 text-lg">Browse our extensive collection of foods with detailed nutritional
                    information.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($foods as $food)
                    @php
                        $nutrients = $food->nutrients;
                        $categoryColors = [
                            'Fruits' => 'blue',
                            'Vegetables' => 'green',
                            'Proteins' => 'red',
                            'Grains' => 'yellow',
                            'Dairy' => 'purple',
                            'Other' => 'gray'
                        ];
                        $categoryColor = $food->category ? ($categoryColors[$food->category->name] ?? 'blue') : 'blue';
                    @endphp
                    <x-food-card
                        image="{{ $food->image_url ?? 'https://images.unsplash.com/photo-1550258987-190a2d41a8ba?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=776&q=80' }}"
                        name="{{ $food->name }}"
                        category="{{ $food->category->name ?? 'Food' }}"
                        categoryColor="{{ $categoryColor }}"
                        calories="{{ $nutrients['calories'] ?? $food->getCalories() ?? '0' }}"
                        protein="{{ $nutrients['protein'] ?? '0' }}"
                        carbs="{{ $nutrients['carbs']  ?? '0' }}"
                        fats="{{ $nutrients['fat'] ?? '0' }}"
                        servingSize="{{ $food->portion_default ?? '100g' }}"
                    />
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/foods') }}"
                   class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center hover:scale-105 transition duration-300">
                    Explore Foods Library <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-blue-600/20 to-purple-600/20">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto fade-in-element">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your <span class="gradient-text">Fitness Journey</span>?
                </h2>
                <p class="text-gray-300 text-lg mb-8">Get access to our exercises, meals, and foods database to help
                    achieve your fitness goals.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    @guest
                        <a href="{{ route('register') }}"
                           class="btn-primary py-4 px-10 rounded-full text-white font-medium text-lg flex items-center shadow-lg hover:scale-105 transition duration-300">
                            Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('nutrition-plans.create') }}"
                           class="btn-primary py-4 px-10 rounded-full text-white font-medium text-lg flex items-center shadow-lg hover:scale-105 transition duration-300">
                            Create Your Plan <i class="fas fa-utensils ml-2"></i>
                        </a>
                    @endguest
                    <a href="#features"
                       class="bg-white/10 hover:bg-white/20 py-4 px-10 rounded-full text-white font-medium text-lg flex items-center border border-white/10 transition duration-300 hover:scale-105">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to top button -->
    <button id="backToTop"
            class="fixed bottom-8 right-8 bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition duration-300 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection

@section('scripts')
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Fade-in animation for elements with .fade-in-element class
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.fade-in-element').forEach(element => {
                element.classList.add('opacity-0', 'translate-y-10', 'transition', 'duration-1000');
                observer.observe(element);
            });

            // Back to top button
            const backToTopButton = document.getElementById('backToTop');

            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopButton.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Image lazy loading
            if ('loading' in HTMLImageElement.prototype) {
                const images = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(img => {
                    img.src = img.dataset.src;
                });
            } else {
                // Fallback for browsers that don't support lazy loading
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
                document.body.appendChild(script);
            }
        });
    </script>
@endsection
