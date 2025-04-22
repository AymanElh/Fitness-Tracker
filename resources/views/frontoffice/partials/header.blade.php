<header class="fixed w-full z-50 transition-all duration-300" id="main-header">
    <div class="glass-effect px-4 py-3">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                        <span class="mr-2 text-3xl"><i class="fas fa-heartbeat text-blue-500"></i></span>
                        <span class="gradient-text">FitTrack</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#features" class="text-gray-300 hover:text-white hover:scale-105 transition duration-300">Features</a>
                    <a href="#exercises" class="text-gray-300 hover:text-white hover:scale-105 transition duration-300">Exercises</a>
                    <a href="#nutrition" class="text-gray-300 hover:text-white hover:scale-105 transition duration-300">Nutrition</a>
                    <a href="#testimonials" class="text-gray-300 hover:text-white hover:scale-105 transition duration-300">Testimonials</a>
                </div>

                <div class="flex items-center space-x-4">
                    @if(Auth::check())
                        <a class="text-gray-300 hover:text-white transition duration-300 hidden md:inline" href="{{ route('logout') }}">Logout</a>
                    @else
                        <a href="{{ url('/login') }}" class="text-gray-300 hover:text-white transition duration-300 hidden md:inline">Login</a>
                        <a href="{{ url('/register') }}" class="btn-primary py-2 px-6 rounded-full text-white font-medium flex items-center">
                            Get Started <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="#features" class="text-gray-300 hover:text-white transition duration-300">Features</a>
                    <a href="#exercises" class="text-gray-300 hover:text-white transition duration-300">Exercises</a>
                    <a href="#nutrition" class="text-gray-300 hover:text-white transition duration-300">Nutrition</a>
                    <a href="#testimonials" class="text-gray-300 hover:text-white transition duration-300">Testimonials</a>
                    <a href="{{ url('/login') }}" class="text-gray-300 hover:text-white transition duration-300">Login</a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const header = document.getElementById('main-header');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Change header background on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                header.classList.add('backdrop-blur-lg');
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('backdrop-blur-lg');
                header.classList.remove('shadow-lg');
            }
        });
    });
</script>
