<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow w-full max-w-sm mx-auto">
    <a href="{{ route('product.detail', $product_id ?? 7) }}">
        <div class="h-32 sm:h-40 md:h-48 overflow-hidden">
            <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-auto rounded-md">
        </div>
        <div class="p-2 sm:p-3 md:p-4">
            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs sm:text-sm font-semibold mb-2">{{ $type }}</span>
            <h3 class="font-semibold text-xs sm:text-sm md:text-base mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 font-bold text-sm sm:text-base">{{ $price }}</div>
            @php
            $rating = $rating ?? 0;
            $fullStars = floor($rating); // jumlah bintang penuh
            $hasHalfStar = ($rating - $fullStars) >= 0.25 && ($rating - $fullStars) < 0.75;
                $emptyStars=5 - $fullStars - ($hasHalfStar ? 1 : 0);
                @endphp

                <div class="mt-4 flex items-center justify-left gap-0.5 text-yellow-400 text-xs">
                {{-- Bintang penuh --}}
                @for ($i = 0; $i < $fullStars; $i++)
                    <i class="fas fa-star"></i>
                    @endfor

                    {{-- Bintang setengah --}}
                    @if ($hasHalfStar)
                    <i class="fas fa-star-half-alt"></i>
                    @endif

                    {{-- Bintang kosong --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star"></i>
                        @endfor

                        {{-- Teks rating --}}
                        <span class="ml-1 text-gray-600 text-[10px]">({{ number_format($rating, 1) }})</span>
        </div>
</div>
</a>
</div>