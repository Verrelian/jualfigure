@extends('layout.app')

@section('title', 'Hasil Pencarian')

@section('content')
@include('component.search')
<div class="container mx-auto px-4 py-6">
  <h2 class="text-2xl font-semibold mb-4">
    Hasil pencarian untuk: "<span class="text-blue-600">{{ $keyword }}</span>"
  </h2>

  @if($produk->count())
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($produk as $item)
        <a href="{{ route('product.detail', $item->product_id) }}"
           class="border rounded-lg overflow-hidden shadow hover:shadow-md transition duration-200 bg-white">
          <img src="{{ asset($item->gambar_url) }}"
               alt="{{ $item->product_name }}"
               class="w-full h-48 object-cover">

          <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $item->product_name }}</h3>
            <p class="text-sm text-gray-500 truncate">{{ Str::limit($item->description, 50) }}</p>
            <p class="mt-1 text-blue-600 font-bold">{{ $item->formatted_harga }}</p>
          </div>
        </a>
      @endforeach
    </div>
  @else
    <div class="text-gray-500">
      Tidak ada produk yang ditemukan untuk "<strong>{{ $keyword }}</strong>".
    </div>
  @endif
</div>
@endsection
