@extends('layout.apps')
@section('content')
<div class="flex min-h-screen overflow-hidden">
  @include('component.seller.sidebar')
  <main class="flex-1 bg-gray-100 p-6 overflow-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-semibold text-gray-800">Kelola Produk</h1>
      <button id="btnAddProduct" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Produk
      </button>
    </div>

    <!-- Table Container with better responsive design -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
      <div class="overflow-x-hidden">
        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
          <thead class="bg-gray-50 text-sm text-gray-600">
            <tr class="border-b border-gray-200">
              <th class="px-6 py-4 text-left font-semibold">No</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Gambar</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-48">Nama Produk</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-64">Deskripsi</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Tipe</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Harga</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Stok</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
            </tr>
          </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            @forelse ($produk as $index => $item)
            <tr class="hover:bg-gray-50 transition-colors duration-200 ease-in-out">
              <td class="px-6 py-4">{{ $index + 1 }}</td>
              <!-- Image Cell -->
              <td class="px-4 py-3">
                @if($item->image)
                <div class="relative group w-20 h-20 cursor-zoom-in" onclick="previewImage('{{ asset('images/' . $item->image) }}')">
                  <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->product_name }}"
                      class="w-15 h-15 object-cover rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200 origin-center">
                </div>
                @else
                  <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                @endif
              </td>

              <!-- Product Name with Tooltip -->
              <td class="px-4 py-3 w-40 whitespace-normal break-words">
                <div class="text-sm font-medium text-gray-900 cursor-help relative group">
                  <span class="truncate block max-w-48">{{ $item->product_name }}</span>
                  <!-- Tooltip -->
                  <div class="absolute left-0 top-full mt-1 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity z-20 whitespace-nowrap">
                    {{ $item->product_name }}
                  </div>
                </div>
              </td>

              <!-- GANTI bagian ini aja di HTML table -->
              <td class="px-6 py-4 text-gray-700">
                @if(strlen($item->description) > 50)
                  <div class="truncate-description cursor-pointer" onclick="toggleDescription(this)">
                    <span class="short-text">{{ Str::limit($item->description, 100, '') }}</span>
                    <span class="full-text hidden">{{ $item->description }}</span>
                    <span class="toggle-btn text-blue-500 hover:text-blue-600 ml-1">...more</span>
                  </div>
                @else
                  {{ $item->description }}
                @endif
              </td>

              <!-- Type Badge -->
              <td class="px-4 py-3">
                <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">
                  {{ $item->type }}
                </span>
              </td>

              <!-- Price -->
              <td class="px-4 py-3 text-sm font-medium text-gray-900">
                Rp{{ number_format($item->price, 0, ',', '.') }}
              </td>

              <!-- Stock Badge -->
              <td class="px-4 py-3">
                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $item->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                  {{ $item->stock > 0 ? $item->stock : 'Habis' }}
                </span>
              </td>

              <!-- Actions - Improved with Dropdown -->
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center gap-2">

                <!-- Edit -->
                <button onclick="openEditModal({{ json_encode($item) }})"
                        class="text-blue-500 hover:text-blue-700"
                        title="Edit Produk">
                  <i class="fas fa-pen-to-square"></i>
                </button>

                <!-- Spesifikasi -->
                <button onclick="showSpecModal({{ $item->product_id }})"
                        class="text-green-500 hover:text-green-700"
                        title="Lihat Spesifikasi">
                  <i class="fas fa-circle-info"></i>
                </button>

                <!-- Hapus -->
                <button onclick="openDeleteModal({{ $item->product_id }}, '{{ $item->product_name }}')"
                        class="text-red-500 hover:text-red-700"
                        title="Hapus Produk">
                  <i class="fas fa-trash-alt"></i>
                </button>

              </div>
            </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                <div class="flex flex-col items-center">
                  <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                  </svg>
                  <p class="text-lg font-medium">Belum ada produk</p>
                  <p class="text-sm">Mulai tambahkan produk pertama Anda</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Specification -->
    <div id="specModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
      <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-6 relative mx-4">
        <button onclick="closeSpecModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Spesifikasi Produk</h2>
        <div id="specContent" class="space-y-3">
          <!-- Content will be loaded here -->
        </div>
      </div>
    </div>

    <!-- Modal Add/Edit Product -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Tambah Produk Baru</h2>
            <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-140px)]">
          <form id="productForm" action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="productId" name="productId">
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Left Column -->
              <div class="space-y-4">
                <div>
                  <label for="productName" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                  <input type="text" id="productName" name="product_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama produk" required>
                </div>

                <div>
                  <label for="productType" class="block text-sm font-medium text-gray-700 mb-2">Tipe Produk</label>
                  <select id="productType" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Pilih Tipe Produk</option>
                    <option value="Pop Up Parade">Pop Up Parade</option>
                    <option value="Hot Toys">Hot Toys</option>
                    <option value="Nendoroid">Nendoroid</option>
                  </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" id="productPrice" name="price" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" required>
                  </div>
                  <div>
                    <label for="productStock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" id="productStock" name="stock" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0" required>
                  </div>
                </div>
              </div>

              <!-- Right Column -->
              <div class="space-y-4">
                <div>
                  <label for="productDescription" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                  <textarea id="productDescription" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Masukkan deskripsi produk" required></textarea>
                </div>

                <div>
                  <label for="productImage" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                  <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                    <input type="file" id="productImage" name="image" accept="image/*" class="hidden">
                    <div class="cursor-pointer" onclick="document.getElementById('productImage').click()">
                      <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      <p class="text-sm text-gray-600">Klik untuk upload gambar</p>
                      <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF (Maks. 2MB)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Specifications Section -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
              <h3 class="text-lg font-medium text-gray-900 mb-4">Spesifikasi Produk</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                  <label for="scale" class="block text-sm font-medium text-gray-700 mb-1">Skala</label>
                  <input type="text" id="scale" name="specification[scale]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="1/7, 1/12">
                </div>
                <div>
                  <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                  <input type="text" id="material" name="specification[material]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="PVC, Resin">
                </div>
                <div>
                  <label for="manufacture" class="block text-sm font-medium text-gray-700 mb-1">Manufaktur</label>
                  <input type="text" id="manufacture" name="specification[manufacture]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Good Smile Company">
                </div>
                <div>
                  <label for="release_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rilis</label>
                  <input type="date" id="release_date" name="specification[release_date]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                  <label for="series" class="block text-sm font-medium text-gray-700 mb-1">Series</label>
                  <input type="text" id="series" name="specification[series]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="One Piece, Naruto">
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <div class="flex justify-end space-x-3">
            <button type="button" id="btnCancelModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
              Batal
            </button>
            <button type="submit" id="btnSaveProduct" form="productForm" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
              <span id="saveButtonText">Simpan</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900">Konfirmasi Hapus</h2>
        </div>
        <div class="px-6 py-4">
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-gray-900">Apakah Anda yakin ingin menghapus produk ini?</p>
              <p class="text-sm text-gray-600 mt-1">Produk "<span id="deleteProductName" class="font-semibold"></span>" akan dihapus secara permanen.</p>
            </div>
          </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
          <!-- Kesalahan pada method, sebelumnya POST harusnya DELETE -->
          <form id="deleteForm" action="#" method="DELETE">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
              <button type="button" id="btnCancelDelete" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Batal
              </button>
              <button type="submit" id="btnConfirmDelete" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                Hapus
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Preview Gambar -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
      <div class="relative">
        <img id="imagePreviewSrc" src="" alt="Preview" class="max-w-full max-h-[90vh] rounded-lg shadow-xl">
        <button onclick="closeImagePreview()" class="absolute top-2 right-2 bg-white rounded-full p-2 shadow hover:bg-gray-100 text-xl font-bold">
          ×
        </button>
      </div>
    </div>
  </main>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
  <span id="toastMessage">Berhasil!</span>
</div>

<script>
  window.isProfileComplete = @json($isProfileComplete);
  console.log("isProfileComplete (from blade):")
</script>
<!-- Load External JavaScript -->
<script src="{{ asset('js/crud.js') }}"></script>

<!-- Flash Messages -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
  showToast('{{ session("success") }}', 'success');
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
  showToast('{{ session("error") }}', 'error');
});
</script>
@endif

@endsection