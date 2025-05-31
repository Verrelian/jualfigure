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
    @php
        // Get trending products (you might want to replace this with actual logic from your controller)
        $trendingProducts = App\Models\Produk::inRandomOrder()
            ->inStock()
            ->take(6)
            ->get();
        
        // Get regular products
        $regularProducts = App\Models\Produk::inRandomOrder()
            ->inStock()
            ->take(5)
            ->get();
    @endphp

    <!-- Product Ranking -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Trending</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($trendingProducts as $product)
                @include('component.product-ranking', [
                    'id' => $product->id,
                    'image' => $product->gambar_url,
                    'type' => $product->type,
                    'title' => $product->nama,
                    'price' => $product->formatted_harga
                ])
            @endforeach
        </div>
    </div>

    <!-- Product Items -->
    <div class="bg-gray-200 p-4 rounded-md mt-7 mb-7">
        <h2 class="text-lg font-bold mb-3">Product Items</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($regularProducts as $product)
                @include('component.product-card', [
                    'id' => $product->id,
                    'image' => $product->gambar_url,
                    'type' => $product->type,
                    'title' => $product->nama,
                    'price' => $product->formatted_harga
                ])
            @endforeach
        </div>
    </div>
@endsection 