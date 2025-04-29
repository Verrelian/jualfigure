<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('product.detail', $id ?? 7) }}">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform hover:scale-105">
        </div>
        <div class="p-4">
            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold mb-2">{{ $type }}</span>
            <h3 class="font-semibold text-sm mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 font-bold">{{ $price }}</div>
        </div>
    </a>
</div>