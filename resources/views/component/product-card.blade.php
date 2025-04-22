<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-40 object-cover">
    <div class="p-4">
        <h3 class="text-sm font-medium text-gray-900">{{ $title }}</h3>
        <p class="text-xs text-gray-600 mt-1">{{ $description }}</p>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-sm font-bold text-gray-900">{{ $price }}</span>
            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs">Buy Now</button>
        </div>
    </div>
</div>