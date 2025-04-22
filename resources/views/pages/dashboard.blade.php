@extends('layout.app')

@section('title', 'Home - Figure Collection Store')

@section('content')
    <!-- Banner -->
    <div class="bg-white rounded-lg overflow-hidden shadow-md mb-6">
        <img src="/image/banner.jpeg" alt="Banner" class="w-full h-60 object-cover">
        <p class="text-white text-lg">Find and collect your favorite anime and game figurines</p>
    </div>

    <!-- Product Ranking -->
    @include('component.product_ranking'), [
        'rankings' =>
            ['image' => 'image/p1.jpg', 'title' => 'Figure 1'],
            ['image' => 'image/p2.jpg', 'title' => 'Figure 2'],
            ['image' => 'image/p3.jpg', 'title' => 'Figure 3'],
            ['image' => 'image/p4.jpg', 'title' => 'Figure 4'],
            ['image' => 'image/p5.jpg', 'title' => 'Figure 5']
    ]

    <!-- Product Items -->
    <div class="mt-8">
        <h2 class="text-lg font-bold mb-3">Product Items</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @include('component.product-card', [
                'image' => '/images/figure1.jpg',
                'title' => 'Anime Figure 1',
                'description' => 'Limited Edition Figure',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'image' => '/images/figure2.jpg',
                'title' => 'Anime Figure 2',
                'description' => 'Premium Collection',
                'price' => '$79.99'
            ])
            @include('component.product-card', [
                'image' => '/images/figure3.jpg',
                'title' => 'Anime Figure 3',
                'description' => 'Special Edition',
                'price' => '$99.99'
            ])
            @include('component.product-card', [
                'image' => '/images/figure4.jpg',
                'title' => 'Anime Figure 4',
                'description' => 'Collector Item',
                'price' => '$129.99'
            ])
            @include('component.product-card', [
                'image' => '/images/figure5.jpg',
                'title' => 'Anime Figure 5',
                'description' => 'Rare Figure',
                'price' => '$149.99'
            ])
        </div>
    </div>

    <!-- Posts -->
    <div class="mt-8">
        <h2 class="text-lg font-bold mb-3">Post</h2>
        <div class="bg-gray-200 p-4 rounded-md">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-2/3 pr-4">
                    <h3 class="font-bold text-sm">Eco-friendliness in Designer Toys:</h3>
                    <p class="text-xs mt-1">How manufacturers are moving toward sustainable practices...</p>
                    <p class="text-xs mt-2">From materials to packaging, eco-friendly initiatives are changing the industry while still providing high-quality collectibles.</p>
                </div>
                <div class="md:w-1/3 mt-4 md:mt-0">
                    <div class="bg-green-500 rounded-md p-4 text-white font-bold text-center">
                        <p class="text-sm">ECO</p>
                        <p class="text-xl">FRIENDLINESS</p>
                        <p class="text-xs">IN THE WORLD OF DESIGNER TOYS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection