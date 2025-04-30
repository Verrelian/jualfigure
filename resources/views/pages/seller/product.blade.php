@extends('layout.apps')

@section('content')
<div class="flex min-h-screen">
  <!-- Sidebar -->
    @include('component.seller.sidebar')

  <!-- Main Content -->
  <main class="flex-1 bg-gray-100 p-6">
    <h1 class="text-2xl font-semibold mb-4">Kelola Produk</h1>

    <!-- Button Tambah Produk -->
    <div class="mb-4">
      <button id="btnAddProduct" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Produk</button>
    </div>

    <!-- Tabel Produk -->
    <div class="bg-white p-4 rounded shadow">
      <table class="min-w-full text-left text-sm">
        <thead>
          <tr class="border-b">
            <th class="py-2 px-4 font-medium">Nama Produk</th>
            <th class="py-2 px-4 font-medium">Harga</th>
            <th class="py-2 px-4 font-medium">Stok</th>
            <th class="py-2 px-4 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody id="productTableBody">
          <!-- Data produk akan ditampilkan di sini -->
        </tbody>
      </table>
    </div>

    <!-- Modal Tambah/Edit Produk -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Tambah Produk Baru</h2>

        <form id="productForm">
          <input type="hidden" id="productId" value="">

          <div class="mb-4">
            <label for="productName" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" id="productName" name="productName" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div class="mb-4">
            <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
            <input type="number" id="productPrice" name="productPrice" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div class="mb-4">
            <label for="productStock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" id="productStock" name="productStock" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          </div>

          <div class="flex justify-end gap-2">
            <button type="button" id="btnCancelModal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
            <button type="submit" id="btnSaveProduct" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus</h2>

        <p class="mb-4">Apakah Anda yakin ingin menghapus produk "<span id="deleteProductName"></span>"?</p>

        <div class="flex justify-end gap-2">
          <button type="button" id="btnCancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
          <button type="button" id="btnConfirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
// Data sampel produk (untuk simulasi)
let products = [
  { id: 1, name: 'Action Figure Naruto', price: 150000, stock: 20 },
  { id: 2, name: 'Manga One Piece Vol. 1', price: 45000, stock: 15 },
  { id: 3, name: 'Nendoroid Hatsune Miku', price: 650000, stock: 5 }
];

// Format angka sebagai Rupiah
function formatRupiah(angka) {
  return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Tampilkan data produk dalam tabel
function renderProducts() {
  const tableBody = document.getElementById('productTableBody');
  tableBody.innerHTML = '';

  products.forEach(product => {
    const row = document.createElement('tr');
    row.className = 'border-b hover:bg-gray-50';

    row.innerHTML = `
      <td class="py-2 px-4">${product.name}</td>
      <td class="py-2 px-4">${formatRupiah(product.price)}</td>
      <td class="py-2 px-4">${product.stock}</td>
      <td class="py-2 px-4 space-x-2">
        <button class="text-blue-600 hover:underline edit-product" data-id="${product.id}">Edit</button>
        <button class="text-red-600 hover:underline delete-product" data-id="${product.id}">Hapus</button>
      </td>
    `;

    tableBody.appendChild(row);
  });

  // Tambahkan event listener untuk tombol edit dan hapus
  document.querySelectorAll('.edit-product').forEach(button => {
    button.addEventListener('click', function() {
      const productId = parseInt(this.getAttribute('data-id'));
      openEditModal(productId);
    });
  });

  document.querySelectorAll('.delete-product').forEach(button => {
    button.addEventListener('click', function() {
      const productId = parseInt(this.getAttribute('data-id'));
      openDeleteModal(productId);
    });
  });
}

// Buka modal tambah produk
function openAddModal() {
  document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
  document.getElementById('productId').value = '';
  document.getElementById('productName').value = '';
  document.getElementById('productPrice').value = '';
  document.getElementById('productStock').value = '';
  document.getElementById('productModal').classList.remove('hidden');
  document.getElementById('productModal').classList.add('flex');
}

// Buka modal edit produk
function openEditModal(productId) {
  const product = products.find(p => p.id === productId);
  if (product) {
    document.getElementById('modalTitle').textContent = 'Edit Produk';
    document.getElementById('productId').value = product.id;
    document.getElementById('productName').value = product.name;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productStock').value = product.stock;
    document.getElementById('productModal').classList.remove('hidden');
    document.getElementById('productModal').classList.add('flex');
  }
}

// Tutup modal produk
function closeProductModal() {
  document.getElementById('productModal').classList.remove('flex');
  document.getElementById('productModal').classList.add('hidden');
}

// Buka modal konfirmasi hapus
function openDeleteModal(productId) {
  const product = products.find(p => p.id === productId);
  if (product) {
    document.getElementById('deleteProductName').textContent = product.name;
    document.getElementById('btnConfirmDelete').setAttribute('data-id', productId);
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
  }
}

// Tutup modal konfirmasi hapus
function closeDeleteModal() {
  document.getElementById('deleteModal').classList.remove('flex');
  document.getElementById('deleteModal').classList.add('hidden');
}

// Simpan produk (tambah atau edit)
function saveProduct(event) {
  event.preventDefault();

  const productId = document.getElementById('productId').value;
  const name = document.getElementById('productName').value;
  const price = parseInt(document.getElementById('productPrice').value);
  const stock = parseInt(document.getElementById('productStock').value);

  if (productId === '') {
    // Tambah produk baru
    const newId = products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1;
    products.push({ id: newId, name, price, stock });
  } else {
    // Edit produk yang ada
    const index = products.findIndex(p => p.id === parseInt(productId));
    if (index !== -1) {
      products[index] = { id: parseInt(productId), name, price, stock };
    }
  }

  renderProducts();
  closeProductModal();

  // Tampilkan notifikasi (opsional)
  alert(productId === '' ? 'Produk berhasil ditambahkan!' : 'Produk berhasil diperbarui!');
}

// Hapus produk
function deleteProduct(productId) {
  products = products.filter(p => p.id !== productId);
  renderProducts();
  closeDeleteModal();

  // Tampilkan notifikasi (opsional)
  alert('Produk berhasil dihapus!');
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
  // Render produk saat halaman dimuat
  renderProducts();

  // Tombol Tambah Produk
  document.getElementById('btnAddProduct').addEventListener('click', openAddModal);

  // Tombol Batal pada modal produk
  document.getElementById('btnCancelModal').addEventListener('click', closeProductModal);

  // Form Submit untuk menyimpan produk
  document.getElementById('productForm').addEventListener('submit', saveProduct);

  // Tombol Batal pada modal konfirmasi hapus
  document.getElementById('btnCancelDelete').addEventListener('click', closeDeleteModal);

  // Tombol Konfirmasi Hapus
  document.getElementById('btnConfirmDelete').addEventListener('click', function() {
    const productId = parseInt(this.getAttribute('data-id'));
    deleteProduct(productId);
  });
});
</script>
@endsection