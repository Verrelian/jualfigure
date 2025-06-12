<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow w-full max-w-sm mx-auto">
    <a href="{{ route('product.detail', $product_id ?? 7) }}">
        <div class="h-32 sm:h-40 md:h-48 overflow-hidden">
            <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-auto rounded-md">
        </div>
            <div class="p-2 sm:p-3 md:p-4">
              <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs sm:text-sm font-semibold mb-2">{{ $type }}</span>
            <h3 class="font-semibold text-xs sm:text-sm md:text-base mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 font-bold text-sm sm:text-base">{{ $price }}</div>
        </div>
    </a>
</div>
