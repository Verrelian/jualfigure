<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($categories as $key => $category)
    <div class="category-card relative rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl {{ $activeCategory === $key ? 'ring-4 ring-blue-400' : '' }}"
         data-category="{{ $key }}"
         onclick="loadProducts('{{ $key }}')">
        <img src="{{ asset('images/categories/' . $key . '.jpg') }}" 
             alt="{{ $category }}" 
             class="w-full h-64 object-cover">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
            <div>
                <h3 class="text-white text-xl font-bold">{{ $category }}</h3>
                <div class="flex items-center mt-1 text-white/90">
                    @if($key === 'nendoroid')
                    <span class="text-yellow-400 mr-1">★</span> Best Selling
                    @elseif($key === 'popup')
                    <span class="text-pink-400 mr-1">↑</span> Trending
                    @else
                    <span class="text-purple-400 mr-1">✧</span> Premium
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>