<div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
    <div class="h-40 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover transition duration-300 transform hover:scale-105">
    </div>
    <div class="p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-lg font-semibold text-white">{{ $name }}</h3>
            <span class="px-3 py-1 rounded-full bg-{{ $categoryColor ?? 'green' }}-500/20 text-{{ $categoryColor ?? 'green' }}-400 text-xs font-semibold">
                {{ $category }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center mr-2">
                    <i class="fas fa-fire text-blue-400"></i>
                </div>
                <div>
                    <p class="text-gray-400">Calories</p>
                    <p class="font-medium text-white">{{ $calories }} kcal</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center mr-2">
                    <i class="fas fa-drumstick-bite text-purple-400"></i>
                </div>
                <div>
                    <p class="text-gray-400">Protein</p>
                    <p class="font-medium text-white">{{ $protein }}g</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-yellow-500/20 flex items-center justify-center mr-2">
                    <i class="fas fa-bread-slice text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-gray-400">Carbs</p>
                    <p class="font-medium text-white">{{ $carbs }}g</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center mr-2">
                    <i class="fas fa-oil-can text-green-400"></i>
                </div>
                <div>
                    <p class="text-gray-400">Fats</p>
                    <p class="font-medium text-white">{{ $fats }}g</p>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-3 border-t border-slate-700">
            <span class="text-gray-400 text-sm">{{ $servingSize }}</span>
            <button class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 p-2 rounded-full transition duration-300" title="Add to meal plan">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</div>
