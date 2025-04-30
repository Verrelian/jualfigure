<!-- Collection Card Component -->
<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
        <div class="absolute bottom-0 left-0 p-3 text-white">
            <h3 class="font-bold">{{ $title }}</h3>
            <p class="text-xs">{{ $count }}</p>
        </div>
    </div>
    <div class="p-3 bg-white">
        <a href="{{ url('/dashboard') }}" class="text-blue-600 text-sm font-medium hover:underline">View Collection</a>
    </div>
</div>