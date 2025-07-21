<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow w-full max-w-sm mx-auto">
    <a href="product/{{ $product_id }}" class="block">
        <div class="aspect-square sm:aspect-[4/5] overflow-hidden bg-gray-100 rounded-md">
            <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}"
                class="w-full h-full object-cover rounded-md" />
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