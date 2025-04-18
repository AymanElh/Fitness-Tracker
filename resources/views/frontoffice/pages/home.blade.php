@extends('layouts.app')

@section('title', 'FitTrack - Your Fitness Companion')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 to-slate-900/80 z-10"></div>
            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" alt="Hero Background" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-4 pt-32 pb-20 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in-element">
                    <span class="px-4 py-2 rounded-full bg-blue-500/10 text-blue-400 text-sm font-semibold inline-block mb-6">
                        FITNESS TRACKING PLATFORM
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight text-shadow">
                        Transform Your Body, <span class="gradient-text">Track Your Progress</span>
                    </h1>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Track your workouts, plan your meals, and achieve your fitness goals with our comprehensive tools.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ url('/register') }}" class="btn-primary py-4 px-8 rounded-full text-white font-medium text-lg flex items-center shadow-lg">
                            Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#features" class="bg-white/10 hover:bg-white/20 py-4 px-8 rounded-full text-white font-medium text-lg flex items-center border border-white/10 transition duration-300">
                            <i class="fas fa-play-circle mr-2"></i> See how it works
                        </a>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <img src="https://i.imgur.com/jSVIoMO.png" alt="Dashboard Preview" class="w-full rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="px-4 py-2 rounded-full bg-blue-500/10 text-blue-400 text-sm font-semibold inline-block mb-4">
                    FEATURES
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Everything You Need to <span class="gradient-text">Achieve Your Goals</span></h2>
                <p class="text-gray-400 text-lg">Find exercises and meals that fit your fitness journey and dietary preferences.</p>
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
            </div>
        </div>
    </section>

    <!-- Exercises Section -->
    <section id="exercises" class="py-24 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6"><span class="gradient-text">Popular Exercises</span> for You</h2>
                <p class="text-gray-400 text-lg">Explore our collection of exercises to build your perfect workout routine.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-exercise-card
                    image="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1769&q=80"
                    name="Barbell Bench Press"
                    level="Intermediate"
                    levelClass="bg-yellow-500/20 text-yellow-400"
                    target="Chest, Triceps, Shoulders"
                    duration="15-20 mins"
                />

                <x-exercise-card
                    image="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Deadlift"
                    level="Advanced"
                    levelClass="bg-red-500/20 text-red-400"
                    target="Back, Legs, Core"
                    duration="25-30 mins"
                />

                <x-exercise-card
                    image="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Bodyweight Squats"
                    level="Beginner"
                    levelClass="bg-green-500/20 text-green-400"
                    target="Quadriceps, Hamstrings, Glutes"
                    duration="10-15 mins"
                />
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/exercises') }}" class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center">
                    Browse All Exercises <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Nutrition Section -->
    <section id="nutrition" class="py-24 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Meal Plans for <span class="gradient-text">Optimal Health</span></h2>
                <p class="text-gray-400 text-lg">Discover balanced meals that fuel your body and support your fitness goals.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-meal-card
                    image="https://images.unsplash.com/photo-1547592180-85f173990554?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Protein-Packed Breakfast Bowl"
                    category="Breakfast"
                    description="Greek yogurt, fresh berries, honey, and granola with a sprinkle of chia seeds."
                    calories="420"
                />

                <x-meal-card
                    image="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1780&q=80"
                    name="Grilled Chicken Salad"
                    category="Lunch"
                    description="Lean grilled chicken breast with mixed greens, avocado, and balsamic dressing."
                    calories="380"
                />

                <x-meal-card
                    image="https://images.unsplash.com/photo-1467003909585-2f8a72700288?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1887&q=80"
                    name="Salmon with Quinoa"
                    category="Dinner"
                    description="Baked salmon fillet with lemon, herbs, and a side of fluffy quinoa and roasted vegetables."
                    calories="550"
                />
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/meals') }}" class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center">
                    Browse All Meals <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Foods Section -->
    <section id="foods" class="py-24 bg-slate-800/50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6"><span class="gradient-text">Nutritious Foods</span> Database</h2>
                <p class="text-gray-400 text-lg">Browse our extensive collection of foods with detailed nutritional information.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <x-food-card
                    image="https://images.unsplash.com/photo-1550258987-190a2d41a8ba?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=776&q=80"
                    name="Blueberries"
                    category="Fruits"
                    categoryColor="blue"
                    calories="57"
                    protein="0.7"
                    carbs="14.5"
                    fats="0.3"
                    servingSize="100g (1 cup)"
                />

                <x-food-card
                    image="https://images.unsplash.com/photo-1607305387299-a3d9611cd469?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Broccoli"
                    category="Vegetables"
                    categoryColor="green"
                    calories="55"
                    protein="3.7"
                    carbs="11.2"
                    fats="0.6"
                    servingSize="100g (1 cup chopped)"
                />

                <x-food-card
                    image="https://images.unsplash.com/photo-1676037150304-e4e30a447c67?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Chicken Breast"
                    category="Proteins"
                    categoryColor="red"
                    calories="165"
                    protein="31"
                    carbs="0"
                    fats="3.6"
                    servingSize="100g (3.5 oz)"
                />

                <x-food-card
                    image="https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                    name="Brown Rice"
                    category="Grains"
                    categoryColor="yellow"
                    calories="112"
                    protein="2.6"
                    carbs="23.5"
                    fats="0.9"
                    servingSize="100g (cooked)"
                />
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/foods') }}" class="btn-primary py-3 px-8 rounded-full text-white font-medium mx-auto inline-flex items-center">
                    Explore Foods Library <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-blue-600/20 to-purple-600/20">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your <span class="gradient-text">Fitness Journey</span>?</h2>
                <p class="text-gray-300 text-lg mb-8">Get access to our exercises, meals, and foods database to help achieve your fitness goals.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ url('/register') }}" class="btn-primary py-4 px-10 rounded-full text-white font-medium text-lg flex items-center shadow-lg">
                        Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#features" class="bg-white/10 hover:bg-white/20 py-4 px-10 rounded-full text-white font-medium text-lg flex items-center border border-white/10 transition duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endsection
