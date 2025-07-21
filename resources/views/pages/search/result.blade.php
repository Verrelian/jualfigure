@extends('layout.app')

@section('title', 'Hasil Pencarian')

@section('content')

<div class="max-w-7xl mx-auto px-4 md:px-8 py-8 min-h-[75vh]">
    <!-- Search Box -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <input type="text" name="search_keyword" value="{{ request('search_keyword') }}"
                   placeholder="Cari produk, pelanggan, pesanan..."
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
                Cari
            </button>
        </form>
    </div>

    <!-- Result Header -->
  <h2 class="text-2xl font-semibold mb-6 text-center">
      Hasil pencarian untuk: <span class="text-blue-600">"{{ $keyword }}"</span>
  </h2>

    <!-- Produk Grid -->
    @if($produk->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produk as $item)
                <a href="{{ route('product.detail', $item->product_id) }}"
                   class="border rounded-xl overflow-hidden shadow hover:shadow-lg transition bg-white">
                    <div class="w-full h-48 bg-gray-100">
                        <img src="{{ asset($item->gambar_url) }}"
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover object-center">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $item->product_name }}</h3>
                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($item->description, 50) }}</p>
                        <p class="mt-1 text-blue-600 font-bold">{{ $item->formatted_harga }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 py-20">
            <p class="text-lg">Tidak ada produk yang ditemukan untuk <strong>"{{ $keyword }}"</strong>.</p>
            <a href="{{ $source === 'explore' ? route('explore') : route('dashboard') }}"
            class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow">
            Kembali ke Produk
            </a>
        </div>
    @endif
</div>

@endsection
