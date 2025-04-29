<div class="bg-white p-2 rounded-md shadow-md">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover">
    <div class="p-4">
        <h3 class="text-sm font-medium text-gray-900">{{ $title }}</h3>
        <p class="text-xs text-gray-600 mt-1">{{ $description }}</p>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-sm font-bold text-gray-900">{{ $price }}</span>
            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs">Buy Now</button>
        </div>
    </div>
</div>
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('product.detail', $id ?? 7) }}">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform hover:scale-105">
        </div>
    </div>
</div>