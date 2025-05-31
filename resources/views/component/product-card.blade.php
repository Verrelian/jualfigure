<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow w-full max-w-sm mx-auto">
    <a href="{{ route('product.detail', $id ?? 7) }}">
        <div class="h-32 sm:h-40 md:h-48 overflow-hidden">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover">
        </div>
            <div class="p-2 sm:p-3 md:p-4">
              <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs sm:text-sm font-semibold mb-2">{{ $type }}</span>
            <h3 class="font-semibold text-xs sm:text-sm md:text-base mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 font-bold text-sm sm:text-base">{{ $price }}</div>
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="/product/{{ $id }}" class="block">
        <div class="aspect-square w-full">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        </div>
        <div class="p-3">
            <p class="text-xs text-gray-500 mb-1">{{ $type }}</p>
            <h3 class="font-semibold text-sm mb-2 line-clamp-2">{{ $title }}</h3>
            <p class="text-lg font-bold text-blue-600">{{ $price }}</p>
            @if(isset($stock))
            <div class="mt-2">
                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">
                    Stock: {{ $stock }}
                </span>
            </div>
            @endif
        </div>
    </a>
</div>
