@extends('layout.apps')
@section('content')
<div class="flex min-h-screen overflow-hidden">
  @include('component.seller.sidebar')
  <main class="flex-1 bg-gray-100 p-6 overflow-auto">
  <h1 class="text-2xl font-semibold mb-4">Kelola Produk</h1>
    <div class="mb-4">
      <button id="btnAddProduct" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Produk</button>
    </div>
  <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto max-w-full">
        <table class="w-full table-auto divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Gambar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Nama Produk</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-64">Deskripsi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Harga</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Stok</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($produk as $index => $item)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
              <td class="px-3 py-4 whitespace-nowrap">
                @if($item->gambar)
                  <img src="{{ asset('images/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-20 h-20 object-cover rounded-lg">
                @else
                  <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                @endif
              </td>
              <td class="px-3 py-4">
                <div class="text-sm font-medium text-gray-900 truncate max-w-32" title="{{ $item->nama }}">{{ $item->nama }}</div>
              </td>
              <td class="px-3 py-4">
                <div class="text-sm text-gray-900 max-w-40">
                  <p class="truncate" title="{{ $item->deskripsi }}">{{ Str::limit($item->deskripsi, 40) }}</p>
                </div>
              </td>
              <td class="px-3 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 truncate max-w-24" title="{{ $item->type }}">
                  {{ Str::limit($item->type, 10) }}
                </span>
              </td>
              <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                <div class="truncate max-w-28" title="Rp{{ number_format($item->harga, 0, ',', '.') }}">
                  Rp{{ number_format($item->harga, 0, ',', '.') }}
                </div>
              </td>
              <td class="px-3 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                  {{ $item->stok > 0 ? $item->stok . ' unit' : 'Habis' }}
                </span>
              </td>
              <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex flex-col space-y-2">
                  <!-- Tombol Lihat Spesifikasi -->
                  <button onclick="showSpecModal({{ $item->id }})"
                          class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lihat Spesifikasi
                  </button>

                  <!-- Tombol Edit & Hapus -->
                  <div class="flex space-x-2 justify-center">
                    <!-- Edit -->
                    <button onclick="openEditModal({{ json_encode($item) }})"
                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 transition">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                      Edit
                    </button>

                    <!-- Hapus -->
                    <button onclick="openDeleteModal({{ $item->id }}, '{{ $item->nama }}')"
                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md text-white bg-red-500 hover:bg-red-600 transition">
                      <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Hapus
                    </button>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <!-- ... empty state tetap sama ... -->
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- modal specification --}}
    <div id="specModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
      <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <button onclick="closeSpecModal()" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700">
          ✕
        </button>
        <h2 class="text-lg font-semibold mb-4">specification Produk</h2>
        <ul id="specList" class="list-disc list-inside text-sm space-y-2">
          <!-- Diisi lewat JS -->
        </ul>
      </div>
    </div>

    {{-- Modal Tambah/Edit Produk --}}
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] overflow-hidden">
          <!-- Modal Header -->
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Tambah Produk Baru</h2>
              <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Modal Body -->
          <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form id="productForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="productId" name="productId">
              <input type="hidden" id="formMethod" name="_method" value="POST">

              <div class="space-y-4">
                <div>
                  <label for="productName" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                  <input type="text" id="productName" name="nama"
                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                         placeholder="Masukkan nama produk" required>
                </div>

                <div>
                  <label for="productDescription" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                  <textarea id="productDescription" name="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            placeholder="Masukkan deskripsi produk" required></textarea>
                </div>

                <div>
                         <label for="productType" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select id="productType" name="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Pilih Type Produk</option>
                                <option value="Pop Up Parade">Pop Up Parade</option>
                                <option value="Hot Toys">Hot Toys</option>
                                <option value="Nendoroid">Nendoroid</option>
                            </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" id="productPrice" name="harga" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0" required>
                  </div>

                  <div>
                    <label for="productStock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" id="productStock" name="stok" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0" required>
                          </div>
                        </div>
                        <!-- Tambahan: Input specification -->
                        <fieldset class="mb-4 border p-4 rounded-md">
                          <legend class="text-base font-semibold text-gray-700 mb-4">specification Produk</legend>

                          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Scale -->
                            <div>
                              <label for="scale" class="block text-sm font-medium text-gray-700 mb-1">Scale</label>
                              <input type="text" id="scale" name="specification[scale]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="1/7, 1/12">
                            </div>

                            <!-- Material -->
                            <div>
                              <label for="material" class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                              <input type="text" id="material" name="specification[material]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="PVC, Resin">
                            </div>

                            <!-- Manufacture -->
                            <div class="md:col-span-2">
                              <label for="manufacture" class="block text-sm font-medium text-gray-700 mb-1">Manufacture</label>
                              <input type="text" id="manufacture" name="specification[manufacture]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Good Smile Company">
                            </div>

                            <!-- Release Date -->
                            <div>
                              <label for="release_date" class="block text-sm font-medium text-gray-700 mb-1">Release Date</label>
                              <input type="date" id="release_date" name="specification[release_date]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Series -->
                            <div class="md:col-span-2">
                              <label for="series" class="block text-sm font-medium text-gray-700 mb-1">Series</label>
                              <input type="text" id="series" name="specification[series]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="One Piece, Naruto">
                            </div>
                          </div>
                        </fieldset>
                    <div>
                      <label for="productImage" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                      <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                          <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                          <div class="flex text-sm text-gray-600">
                            <label for="productImage" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                              <span>Upload gambar</span>
                              <input type="file" id="productImage" name="gambar" accept="image/*" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                          </div>
                          <p class="text-xs text-gray-500">PNG, JPG, GIF sampai 2MB</p>
                        </div>
                      </div>
                    </div>
              </div>
            </form>
          </div>

          <!-- Modal Footer -->
          <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-end space-x-3">
              <button type="button" id="btnCancelModal"
                      class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Batal
              </button>
              <button type="submit" id="btnSaveProduct" form="productForm"
                      class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="saveButtonText">Simpan</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
          <!-- Modal Header -->
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-semibold text-gray-900">Konfirmasi Hapus</h2>
              <button type="button" onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Modal Body -->
          <div class="px-6 py-4">
            <div class="flex items-center mb-4">
              <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-gray-900">Apakah Anda yakin ingin menghapus produk ini?</p>
                <p class="text-sm text-gray-600 mt-1">Produk "<span id="deleteProductName" class="font-semibold"></span>" akan dihapus secara permanen.</p>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <form id="deleteForm" action="#" method="POST">
              @csrf
              @method('DELETE')
              <div class="flex justify-end space-x-3">
                <button type="button" id="btnCancelDelete"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                  Batal
                </button>
                <button type="submit" id="btnConfirmDelete"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                  Hapus
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg transform translate-x-full transition-transform duration-300 z-50">
  <span id="toastMessage">Produk berhasil disimpan!</span>
</div>
<script>
  // Global variables
  let isEditMode = false;
  let currentEditId = null;

  function openAddModal() {
    resetModalState();
    document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
    document.getElementById('saveButtonText').textContent = 'Simpan';
    document.getElementById('productForm').action = '{{ route("product.store") }}';
    document.getElementById('formMethod').value = 'POST';
    showModal('productModal');
  }

  function openEditModal(product) {
    resetModalState();
    isEditMode = true;
    currentEditId = product.id;

    document.getElementById('modalTitle').textContent = 'Edit Produk';
    document.getElementById('saveButtonText').textContent = 'Update';
    document.getElementById('productId').value = product.id;
    document.getElementById('productName').value = product.nama;
    document.getElementById('productDescription').value = product.deskripsi;
    document.getElementById('productType').value = product.type;
    document.getElementById('productPrice').value = product.harga;
    document.getElementById('productStock').value = product.stok;

    // Set form action dan method dengan benar
    document.getElementById('productForm').action = '{{ route("product.update", ":id") }}'.replace(':id', product.id);
    document.getElementById('formMethod').value = 'PUT';

    // Reset semua field spesifikasi terlebih dahulu
    document.getElementById('scale').value = '';
    document.getElementById('material').value = '';
    document.getElementById('manufacture').value = '';
    document.getElementById('release_date').value = '';
    document.getElementById('series').value = '';

    // Isi field spesifikasi jika ada (karena sudah di-load dengan specification)
    if (product.specification) {
      const spec = product.specification;
      if (spec.scale) document.getElementById('scale').value = spec.scale;
      if (spec.material) document.getElementById('material').value = spec.material;
      if (spec.manufacture) document.getElementById('manufacture').value = spec.manufacture;
      if (spec.release_date) document.getElementById('release_date').value = spec.release_date;
      if (spec.series) document.getElementById('series').value = spec.series;
    }

    showModal('productModal');
  }
  function showSpecModal(productId) {
      fetch(`{{ url('seller/product') }}/${productId}/specification`)
      .then(res => res.json())
      .then(data => {
          const list = document.getElementById('specList');
          list.innerHTML = '';

          // cek apakah data kosong object atau ada isinya
          if (!data || Object.keys(data).length === 0) {
              list.innerHTML = '<li class="text-gray-500">Tidak ada specification.</li>';
          } else {
              // data adalah object, jadi gunakan Object.entries() untuk loop
              Object.entries(data).forEach(([key, value], i) => {
                  const item = document.createElement('li');
                  item.textContent = `${key}: ${value}`;
                  list.appendChild(item);
              });
          }

          document.getElementById('specModal').classList.remove('hidden');
      })
      .catch(err => {
          alert('Gagal mengambil data specification');
          console.error(err);
      });
  }

  function closeSpecModal() {
    document.getElementById('specModal').classList.add('hidden');
  }

  function openDeleteModal(productId, productName) {
    document.getElementById('deleteProductName').textContent = productName;
    document.getElementById('deleteForm').action = '{{ route("product.destroy", ":id") }}'.replace(':id', productId);
    showModal('deleteModal');
  }

  // Perbaikan fungsi resetModalState
  function resetModalState() {
    isEditMode = false;
    currentEditId = null;
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';

    // Reset spesifikasi fields
    document.getElementById('scale').value = '';
    document.getElementById('material').value = '';
    document.getElementById('manufacture').value = '';
    document.getElementById('release_date').value = '';
    document.getElementById('series').value = '';
  }

  function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  function closeProductModal() {
    hideModal('productModal');
    resetModalState();
  }

  function closeDeleteModal() {
    hideModal('deleteModal');
  }

  function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded shadow-lg transform transition-transform duration-300 z-50 ${
      type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;

    // Show toast
    toast.classList.remove('translate-x-full');

    // Hide toast after 3 seconds
    setTimeout(() => {
      toast.classList.add('translate-x-full');
    }, 3000);
  }

  // Event listeners
  document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('btnAddProduct').addEventListener('click', openAddModal);
  document.getElementById('btnCancelModal').addEventListener('click', closeProductModal);
  document.getElementById('btnCancelDelete').addEventListener('click', closeDeleteModal);

  // Close modal when clicking outside
  document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeProductModal();
    }
  });

  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeDeleteModal();
    }
  });

  // Perbaikan di bagian form submission handling
  document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = document.getElementById('btnSaveProduct');
    const originalText = document.getElementById('saveButtonText').textContent;

    // Disable button dan show loading
    submitButton.disabled = true;
    document.getElementById('saveButtonText').textContent = 'Menyimpan...';

    fetch(this.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
    .then(response => {
      // Parse JSON response
      return response.json().then(data => {
        return { status: response.status, data: data };
      });
    })
    .then(({ status, data }) => {
      if (data.success) {
        showToast(data.message || (isEditMode ? 'Produk berhasil diupdate!' : 'Produk berhasil ditambahkan!'));
        closeProductModal();
        // Reload page untuk show updated data
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        // Show specific error message
        showToast(data.message || 'Terjadi kesalahan!', 'error');

        // Jika ada errors detail, tampilkan di console untuk debugging
        if (data.errors) {
          console.error('Validation errors:', data.errors);
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('Terjadi kesalahan koneksi!', 'error');
    })
    .finally(() => {
      // Re-enable button
      submitButton.disabled = false;
      document.getElementById('saveButtonText').textContent = originalText;
    });
  });

  // Perbaikan fungsi showToast untuk menampilkan pesan lebih lama jika error
  function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;

    // Tentukan warna berdasarkan tipe
    let bgColor = 'bg-green-500';
    let duration = 3000; // 3 detik untuk success

    switch(type) {
      case 'error':
        bgColor = 'bg-red-500';
        duration = 5000; // 5 detik untuk error
        break;
      case 'warning':
        bgColor = 'bg-yellow-500';
        duration = 4000; // 4 detik untuk warning
        break;
      case 'info':
        bgColor = 'bg-blue-500';
        duration = 3000;
        break;
      default:
        bgColor = 'bg-green-500';
        duration = 3000;
    }

    toast.className = `fixed top-4 right-4 px-6 py-3 rounded shadow-lg transform transition-transform duration-300 z-50 ${bgColor} text-white`;

    // Show toast
    toast.classList.remove('translate-x-full');

    // Hide toast after specified duration
    setTimeout(() => {
      toast.classList.add('translate-x-full');
    }, duration);
  }
  // Handle delete form submission
  document.getElementById('deleteForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const submitButton = document.getElementById('btnConfirmDelete');
    const originalText = submitButton.textContent;

    submitButton.disabled = true;
    submitButton.textContent = 'Menghapus...';

    fetch(this.action, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast(data.message || 'Produk berhasil dihapus!');
        closeDeleteModal();
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        showToast(data.message || 'Terjadi kesalahan!', 'error');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('Terjadi kesalahan saat menghapus data!', 'error');
    })
    .finally(() => {
      submitButton.disabled = false;
      submitButton.textContent = originalText;
    });
  });
  });

  // Handle escape key to close modals
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      if (!document.getElementById('productModal').classList.contains('hidden')) {
        closeProductModal();
      }
      if (!document.getElementById('deleteModal').classList.contains('hidden')) {
        closeDeleteModal();
      }
    }
  });
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
  showToast('{{ session("success") }}');
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