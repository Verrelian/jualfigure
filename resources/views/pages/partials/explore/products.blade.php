@if($products->count() > 0)
    @foreach($products as $product)
        @include('component.product-card', [
            'id' => $product->id,
            'image' => $product->gambar_url,
            'type' => $product->type,
            'title' => $product->nama,
            'price' => $product->formatted_harga,
            'stock' => $product->stok
        ])
    @endforeach
@else
    <div class="col-span-full text-center py-8">
        <p class="text-gray-600">No products found in this category.</p>
    </div>
@endif