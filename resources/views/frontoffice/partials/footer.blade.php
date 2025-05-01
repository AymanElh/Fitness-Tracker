<footer class="bg-slate-900 border-t border-slate-800 py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center mb-4">
                    <span class="mr-2 text-3xl"><i class="fas fa-heartbeat text-blue-500"></i></span>
                    <span class="gradient-text">FitTrack</span>
                </a>
                <p class="mt-4 text-gray-400 leading-relaxed">Your personal companion for fitness and nutrition tracking. Achieve your health goals with our comprehensive tools and personalized guidance.</p>
                <div class="mt-6 flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-500/20 transition duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-500/20 transition duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-500/20 transition duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-500/20 transition duration-300">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center mr-3">
                        <i class="fas fa-link text-blue-400"></i>
                    </span>
                    Quick Links
                </h3>
                <ul class="space-y-4">
                    <li><a href="#features" class="text-gray-400 hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Features</a></li>
                    <li><a href="{{ route('exercises.index') }}" class="text-gray-400 hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Exercises</a></li>
                    <li><a href="{{ route('foods.index') }}" class="text-gray-400 hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Nutrition</a></li>
                    <li><a href="" class="text-gray-400 hover:text-white transition duration-300 flex items-center"><i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Testimonials</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-green-400"></i>
                    </span>
                    Contact
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-envelope text-green-400 mt-1.5 mr-3"></i>
                        <span class="text-gray-400">support@fittrack.com</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone text-green-400 mt-1.5 mr-3"></i>
                        <span class="text-gray-400">+212 6 54 68 47 57</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-green-400 mt-1.5 mr-3"></i>
                        <span class="text-gray-400">123 Fitness St, Health City</span>
                    </li>
                </ul>

                <div class="mt-8">
                    <h4 class="text-white font-medium mb-3">Subscribe to newsletter</h4>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="bg-white/5 border border-white/10 rounded-l-lg px-4 py-2 focus:outline-none focus:border-blue-500 text-white w-full">
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-500 px-4 rounded-r-lg">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500">&copy; {{ date('Y') }} FitTrack. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-500 hover:text-white transition duration-300">Terms</a>
                <a href="#" class="text-gray-500 hover:text-white transition duration-300">Privacy</a>
                <a href="#" class="text-gray-500 hover:text-white transition duration-300">Cookies</a>
                <a href="#" class="text-gray-500 hover:text-white transition duration-300">FAQ</a>
            </div>
        </div>
    </div>
</footer>
