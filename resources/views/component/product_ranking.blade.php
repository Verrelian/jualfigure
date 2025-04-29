<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('product.detail', $id ?? 1) }}">
        <div class="h-40 overflow-hidden">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform hover:scale-105">
        </div>
        <div class="p-3">
            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold mb-1">{{ $type }}</span>
            <h3 class="font-semibold text-xs mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 text-sm font-bold">{{ $price }}</div>
        </div>
    </a>
</div>