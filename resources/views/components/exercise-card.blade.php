<div class="card-gradient rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
    <div class="h-48 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover transition duration-300 transform hover:scale-105">
    </div>
    <div class="p-5">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold text-white">{{ $name }}</h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $levelClass }}">{{ $level }}</span>
        </div>
        <p class="text-gray-400 text-sm mb-3">{{ $target }}</p>
        <div class="flex justify-between items-center">
            <span class="text-gray-400 flex items-center"><i class="fas fa-clock mr-2"></i>{{ $duration }}</span>
            <a href="#" class="text-blue-400 hover:underline flex items-center">Details <i class="fas fa-chevron-right ml-1 text-xs"></i></a>
        </div>
    </div>
</div>
