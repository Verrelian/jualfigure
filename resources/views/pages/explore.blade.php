@extends('layout.app')

@section('type', 'Explore - Figure Collection Store')

@section('content')
    <!-- Explore Header -->
    <div class="flex justify-center mt-5 mb-7">
        <div class="w-full text-center">
            <h1 class="text-3xl font-bold">Explore</h1>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="grid grid-cols-3 gap-4 mb-10">
        <!-- Nendoroid Category -->
        <div class="relative rounded-lg overflow-hidden shadow-md bg-gray-800">
            <div class="aspect-[4/3] w-full">
                <img src="{{ asset('images/p6.jpg') }}" alt="Nendoroid" class="w-full h-80 object-cover">
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Nendoroid</h3>
                <div class="flex items-center">
                    <span class="text-xs">Popular</span>
                    <span class="ml-1 text-yellow-500">★</span>
                </div>
            </div>
        </div>

        <!-- Pop Up Parade Category -->
        <div class="relative rounded-lg overflow-hidden shadow-md bg-gray-800">
            <img src="{{ asset('images/p3.png') }}" alt="Pop Up Parade" class="w-full h-80 object-cover">
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Pop Up Parade</h3>
                <div class="flex items-center">
                    <span class="text-xs">Trending</span>
                </div>
            </div>
        </div>

        <!-- Hot Toys Category -->
        <div class="relative rounded-lg overflow-hidden shadow-md bg-gray-800">
            <img src="{{ asset('images/figure4.jpg') }}" alt="Hot Toys" class="w-full h-80 object-cover">
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2">
                <h3 class="font-bold text-sm">Hot Toys</h3>
                <div class="flex items-center">
                    <span class="text-xs">Premium</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Collections -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Popular Collections</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @include('component.collection-card', [
                'image' => 'images/p1.jpg',
                'title' => 'Zenless Zone Zero',
                'count' => '1 figures'
            ])
            @include('component.collection-card', [
                'image' => 'images/p2.jpg',
                'title' => 'Hololive',
                'count' => '1 figures'
            ])
            @include('component.collection-card', [
                'image' => 'images/p4.png',
                'title' => 'Jujutsu Kaisen',
                'count' => '1 figures'
            ])
            @include('component.collection-card', [
                'image' => 'images/p5.jpg',
                'title' => 'Yu-Gi-Oh!',
                'count' => '2 figures'
            ])
        </div>
    </div>

    <!-- New Releases -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">New Releases</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @include('component.product-card', [
                'id' => 9,
                'image' => 'images/figure3.jpg',
                'type' => 'New Release',
                'title' => 'PVC Figure Himura Kenshin - Rurouni Kenshin (18cm)',
                'price' => '$59.99'
            ])
            @include('component.product-card', [
                'id' => 3,
                'image' => 'images/p3.png',
                'type' => 'New Release',
                'title' => 'Pop Up Parade Frieren - Sousou no Frieren (17cm)',
                'price' => '$49.99'
            ])
            @include('component.product-card', [
                'id' => 6,
                'image' => 'images/p6.jpg',
                'type' => 'New Release',
                'title' => 'Nendroid Aventurine - Honkai Star Rail (10cm)',
                'price' => '$39.99'
            ])
            @include('component.product-card', [
                'id' => 2,
                'image' => 'images/p2.jpg',
                'type' => 'New Release',
                'title' => 'Pop Up Parade Gawr Gura - Hololive Special Edition',
                'price' => '$54.99'
            ])
            @include('component.product-card', [
                'id' => 10,
                'image' => 'images/p4.png',
                'type' => 'New Release',
                'title' => 'Pop Up Parade Satoru Gojo - Jujutsu Kaisen',
                'price' => '$49.99'
            ])
        </div>
    </div>
@endsection