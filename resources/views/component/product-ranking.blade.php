<div class="bg-gray-200 p-4 rounded-md">
    <h2 class="text-lg font-bold mb-3">Product Ranking</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($rankings as $ranking)
        <div class="bg-white p-2 rounded-md shadow-sm">
            <img src="{{ $ranking['image'] }}" alt="{{ $ranking['title'] }}" class="w-full h-24 object-cover">
        </div>
        @endforeach
    </div>
</div>