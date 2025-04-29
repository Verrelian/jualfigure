<<<<<<< HEAD
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('product.detail', $id ?? 1) }}">
        <div class="h-48 overflow-hidden">
            <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform hover:scale-105">
=======
<div class="bg-white p-2 rounded-md shadow-md">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover">
    <div class="p-4">
        <h3 class="text-sm font-medium text-gray-900">{{ $title }}</h3>
        <p class="text-xs text-gray-600 mt-1">{{ $description }}</p>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-sm font-bold text-gray-900">{{ $price }}</span>
            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs">Buy Now</button>
>>>>>>> 86d8820e19cfefa14435660a5796b373ffb64cc9
        </div>
        <div class="p-4">
            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold mb-2">{{ $type }}</span>
            <h3 class="font-semibold text-sm mb-1 truncate">{{ $title }}</h3>
            <div class="text-red-600 font-bold">{{ $price }}</div>
        </div>
    </a>
</div>