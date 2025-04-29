@extends('layout.app')

@section('title', 'Home - Figure Collection Store')

@section('content')
    <!-- Banner Gabungan -->
    <div class="flex justify-center">
        <div class="w-[75%] bg-white rounded-3xl overflow-hidden shadow-md mb-10 relative h-60">
            @include('component.banner')
            <img src="{{ asset('images/banner.jpeg') }}" alt="Banner"  class="absolute inset-0 w-full h-full object-cover z-0">
        </div>
    </div>

    <!-- Product Ranking -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Ranking</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @include('component.product_ranking', [
                'id' => 1,
                'image' => 'images/p1.jpg',
                'title' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product_ranking', [
                'id' => 2,
                'image' => 'images/p2.jpg',
                'title' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
                'type' => 'Limited Edition',
                'price' => '$89.99'
            ])
            @include('component.product_ranking', [
                'id' => 3,
                'image' => 'images/p3.jpg',
                'title' => 'Pop Up Parade Frieren - Sousou no Frieren',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product_ranking', [
                'id' => 4,
                'image' => 'images/p4.jpg',
                'title' => 'Pop up Parade Red Eyes Black Dragon - Yu-Gi-Oh! (18cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product_ranking', [
                'id' => 5,
                'image' => 'images/p5.jpg',
                'title' => 'Pop Up Parade Blue Eyes White Dragon - Yu-Gi-Oh! (17,5cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product_ranking', [
                'id' => 6,
                'image' => 'images/p6.jpg',
                'title' => 'Pop Up Parade Aventurine - Honkai Star Rail (16cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
        </div>
    </div>

    <!-- Product Items -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Items</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @include('component.product-card', [
                'id' => 1,
                'image' => 'images/p1.jpg',
                'title' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'id' => 2,
                'image' => 'images/p2.jpg',
                'title' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
                'type' => 'Limited Edition',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'id' => 3,
                'image' => 'images/p3.jpg',
                'title' => 'Pop Up Parade Frieren - Sousou no Frieren',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'id' => 4,
                'image' => 'images/p4.jpg',
                'title' => 'Pop up Parade Red Eyes Black Dragon - Yu-Gi-Oh! (18cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
            ])
            @include('component.product-card', [
                'id' => 5,
                'image' => 'images/p5.jpg',
                'title' => 'Pop Up Parade Blue Eyes White Dragon - Yu-Gi-Oh! (17,5cm)',
                'type' => '[Exclusive Sale]',
                'price' => '$89.99'
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