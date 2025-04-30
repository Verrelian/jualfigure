@extends('layout.app')

@section('type', 'Home - Figure Collection Store')

@section('content')
    <!-- Banner Gabungan -->
<div class="flex justify-center">
    <div class="w-[75%] bg-white rounded-3xl overflow-hidden shadow-md mb-10 relative h-60">
        @include('component.banner')
        <img src="{{ asset('images/banner.jpeg') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover z-0">
    </div>
</div>


    <!-- Product Ranking -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Ranking</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @include('component.product-ranking', [
                'id' => 1,
                'image' => 'images/p1.jpg',
                'type' => '[Exclusive Sale]',
                'title' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
                'price' => '$79.99'
            ])
            @include('component.product-ranking', [
                'id' => 2,
                'image' => 'images/p2.jpg',
                'type' => '[Exclusive Sale]',
                'title' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
                'price' => '$79.99'
            ])
            @include('component.product-ranking', [
                'id' => 3,
                'image' => 'images/p3.png',
                'type' => '[Exclusive Sale]',
                'title' => 'Pop Up Parade Frieren - Sousou no Frieren',
                'price' => '$79.99'
            ])
            @include('component.product-ranking', [
                'id' => 4,
                'image' => 'images/p4.png',
                'type' => '[Exclusive Sale]',
                'title' => 'Pop Up Parade Satoru Gojo - Murasaki Ver. Jujutsu Kaisen (18cm)',
                'price' => '$79.99'
            ])
            @include('component.product-ranking', [
                'id' => 5,
                'image' => 'images/p5.jpg',
                'type' => '[Exclusive Sale]',
                'title' => 'Pop Up Parade Blue Eyes White Dragon - Yu-Gi-Oh! (17,5cm)',
                'price' => '$79.99'
            ])

            @include('component.product-ranking', [
                'id' => 6,
                'image' => 'images/p6.jpg',
                'type' => '[Exclusive Sale]',
                'title' => 'Nendroid Parade Aventurine - Honkai Star Rail (16cm)',
                'price' => '$79.99'
            ])
        </div>
    </div>


    <!-- Product Items -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Items</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @include('component.product-card', [
                'id' => 7,
                'image' => 'images/figure1.png',
                'type' => 'Anime Figure',
                'title' => ' Nendroid Parade Cute Anime Figure',
                'price' => '$29.99'
            ])
            @include('component.product-card', [
                'id' => 8,
                'image' => 'images/figure2.png',
                'type' => 'Anime Figure',
                'title' => 'Nendroid Parade Rin with Blue hair - Yu-Gi-Oh! (15,5cm)',
                'price' => '$29.99'
            ])
            @include('component.product-card', [
                'id' => 9,
                'image' => 'images/figure3.jpg',
                'type' => 'Special Edition',
                'title' => '[Hanami SALE] PVC Non Scale Figure Himura Kenshin – Rurouni Kenshin',
                'price' => '$49.99'
            ])
            @include('component.product-card', [
                'id' => 10,
                'image' => 'images/figure4.jpg',
                'type' => 'Collector Item',
                'title' => 'Pop Up Parade Red Eyes Black Dragon - Yu-Gi-Oh! (18,5cm)',
                'price' => '$129.99'
            ])
            @include('component.product-card', [
                'id' => 11,
                'image' => 'images/figure5.png',
                'type' => 'Anime Figure 5',
                'title' => 'Rare Figure',
                'price' => '$69.99'
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