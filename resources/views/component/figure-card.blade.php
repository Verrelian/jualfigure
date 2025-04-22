@props(['figure'])

<div class="bg-white p-4 rounded shadow text-center">
    <img src="{{ $figure->image }}" alt="{{ $figure->name }}" class="w-full h-32 object-cover mb-2">
    <div class="text-sm font-medium">{{ $figure->name }}</div>
</div>
