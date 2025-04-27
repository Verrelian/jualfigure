@extends('layout.app')

@section('title', 'Home - Figure Collection Store')

@section('content')
    <!-- Banner Gabungan -->
<div class="flex justify-center">
    <div class="w-[75%] bg-white rounded-3xl overflow-hidden shadow-md mb-10 relative h-60">
        @include('component.banner')
        <img src="/images/banner.jpeg" alt="Banner" class="absolute inset-0 w-full h-full object-cover z-0">
    </div>
</div>


    <!-- Product Ranking -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Ranking</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @include('component.product-ranking', [
                'image' => 'images/p1.jpg',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
            ])
            @include('component.product-ranking', [
                'image' => 'images/p2.jpg',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
            ])
            @include('component.product-ranking', [
                'image' => 'images/p3.png',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade Frieren - Sousou no Frieren',
            ])
            @include('component.product-ranking', [
                'image' => 'images/p4.png',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade Satoru Gojo - Murasaki Ver. Jujutsu Kaisen (18cm)',
            ])
            @include('component.product-ranking', [
                'image' => 'images/p5.jpg',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade Blue Eyes White Dragon - Yu-Gi-Oh! (17,5cm)',
            ])

            @include('component.product-ranking', [
                'image' => 'images/p6.jpg',
                'title' => '[Exclusive Sale]',
                'description' => 'Pop Up Parade Aventurine - Honkai Star Rail (16cm)',
            ])
        </div>
    </div>


    <!-- Product Items -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Items</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @include('component.product-card', [
                'image' => 'images/figure1.png',
                'title' => 'Anime Figure 1',
                'description' => 'Limited Edition Figure',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'image' => 'images/figure2.png',
                'title' => 'Anime Figure 2',
                'description' => 'Premium Collection',
                'price' => '$79.99'
            ])
            @include('component.product-card', [
                'image' => 'images/figure3.jpg',
                'title' => 'Anime Figure 3',
                'description' => 'Special Edition',
                'price' => '$99.99'
            ])
            @include('component.product-card', [
                'image' => 'images/figure4.jpg',
                'title' => 'Anime Figure 4',
                'description' => 'Collector Item',
                'price' => '$129.99'
            ])
            @include('component.product-card', [
                'image' => 'images/figure5.png',
                'title' => 'Anime Figure 5',
                'description' => 'Rare Figure',
                'price' => '$149.99'
            ])
        </div>
    </div>

    <!-- Posts -->
    <div class="mt-7 mb-7">
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