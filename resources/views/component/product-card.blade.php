<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 w-full max-w-xs mx-auto">
    <a href="{{ route('product.detail', $product_id ?? 7) }}" class="block">
        <!-- Gambar -->
        <div class="aspect-square overflow-hidden">
            <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-full object-cover">
        </div>

        <!-- Konten -->
        <div class="p-4">
            <!-- Type/Kategori -->
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                {{ $type }}
            </span>

            <!-- Judul -->
            <h3 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2">
                {{ $title }}
            </h3>

            <!-- Harga -->
            <p class="text-base font-bold text-blue-600 mb-2">
                {{ $price }}
            </p>

            <!-- Stock -->
            @isset($stock)
                <div class="text-xs text-green-700 bg-green-100 inline-block px-2 py-1 rounded-full">
                    Stock: {{ $stock }}
                </div>
            @endisset

            <!-- Rating -->
            @php
                $rating = $rating ?? 0;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75;
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
            @endphp

            @if($rating > 0)
                <div class="mt-3 flex items-center text-yellow-400 text-xs">
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star"></i>
                    @endfor

                    @if ($hasHalfStar)
                        <i class="fas fa-star-half-alt"></i>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star"></i>
                    @endfor

                    <span class="ml-1 text-gray-500 text-[10px]">({{ number_format($rating, 1) }})</span>
                </div>
            @endif
        </div>
    </a>
</div>
