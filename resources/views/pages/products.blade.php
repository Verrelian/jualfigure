@extends('layout.main')

@section('title', 'Products - Figure Collection Store')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Our Products</h1>
    
    <!-- Filter -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-2">Filter Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select class="w-full rounded-md border-gray-300">
                    <option>All Categories</option>
                    <option>Action Figures</option>
                    <option>Collectibles</option>
                    <option>Limited Editions</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Price Range</label>
                <select class="w-full rounded-md border-gray-300">
                    <option>All Prices</option>
                    <option>Under $50</option>
                    <option>$50 - $100</option>
                    <option>$100 - $200</option>
                    <option>Over $200</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sort By</label>
                <select class="w-full rounded-md border-gray-300">
                    <option>Popularity</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest First</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md w-full">Apply Filters</button>
            </div>
        </div>
    </div>
    
    <!-- Product List -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @for ($i = 1; $i <= 10; $i++)
            @include('component.product-card', [
                'image' => '/images/figure'.$i.'.jpg',
                'title' => 'Anime Figure '.$i,
                'description' => 'Premium Collection Figure',
                'price' => '$'.rand(50, 200).'.99'
            ])
        @endfor
    </div>
    
    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <nav class="flex items-center space-x-2">
            <a href="#" class="px-3 py-1 rounded-md bg-gray-200 text-gray-700">Previous</a>
            <a href="#" class="px-3 py-1 rounded-md bg-blue-600 text-white">1</a>
            <a href="#" class="px-3 py-1 rounded-md bg-gray-200 text-gray-700">2</a>
            <a href="#" class="px-3 py-1 rounded-md bg-gray-200 text-gray-700">3</a>
            <a href="#" class="px-3 py-1 rounded-md bg-gray-200 text-gray-700">Next</a>
        </nav>
    </div>
@endsection