@extends('layout.app')

@section('type', 'Home - Figure Collection Store')

@section('banner')
<!-- Banner Gabungan -->
<div class="relative w-full h-60">
    <div class="w-[100%] bg-white shadow-md mb-10 relative h-60">
        @include('component.banner')
        <img src="{{ asset('images/banner.jpeg') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover z-0">
    </div>
</div>
@endsection

@section('content')
    <!-- Product Ranking -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Trending</h2>
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
@endsection