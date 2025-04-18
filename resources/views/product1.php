<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="btc.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD - PUBG Top Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-indigo-800 font-[Plus Jakarta Sans] text-white">
  <!-- Header -->
  <header class="flex items-center bg-indigo-900 fixed top-0 left-0 right-0 z-50 w-full px-6 py-3 gap-4">
    <button @click="open = !open" class="text-white text-2xl focus:outline-none" x-data="{ open: false }">
      ☰
    </button>
    <a href="dashboard_penjual.php">
      <img src="btc.png" alt="BTC Logo" class="w-24">
    </a>
  </header>

  <!-- Offcanvas / Drawer -->
  <div x-show="open" class="fixed top-0 left-0 w-64 h-full bg-indigo-900 text-white z-40 p-6" x-data="{ open: false }">
    <div class="flex justify-between items-center mb-6">
      <img src="btc.png" class="w-36">
      <button @click="open = false" class="text-white text-xl">&times;</button>
    </div>
    <nav class="flex flex-col space-y-4">
      <a href="produk1_penjual.php" class="text-lg">PUBG</a>
      <a href="produk2_penjual.php" class="text-lg">MOBILE LEGEND</a>
      <a href="produk3_penjual.php" class="text-lg">FREE FIRE</a>
    </nav>
  </div>

  <!-- Banner -->
  <div class="pt-20">
    <img src="pubg_banner.jpg" alt="PUBG Banner" class="w-full h-72 object-cover">
    <div class="max-w-7xl mx-auto px-6 flex items-end mt-[-80px]">
      <img src="pubg.jpg" class="w-32 h-44 rounded-lg">
      <div class="ml-4 mb-6">
        <h1 class="text-3xl font-bold">PUBG</h1>
        <p class="text-lg">TENCENT GAMES</p>
      </div>
    </div>
  </div>

  <!-- Produk Section -->
  <div class="max-w-7xl mx-auto px-6 py-6">
    <h3 class="text-xl font-bold mb-4">Edit Produk</h3>
    <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded flex items-center space-x-2">
      <i class="fas fa-plus-circle"></i>
      <span>TAMBAH DATA PRODUK</span>
    </button>

    <!-- Produk Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
      <!-- Sample card -->
      <div class="bg-white/20 p-4 rounded text-center text-white hover:bg-blue-600 transition">
        <img src="" alt="Produk" class="w-16 h-16 object-contain mx-auto">
        <div class="font-bold mt-2">Nama Produk</div>
        <div>Rp Harga</div>
        <div>Stock: 0</div>
        <button @click="editModal = true" class="bg-blue-500 hover:bg-blue-700 mt-2 px-3 py-1 rounded text-sm">Edit</button>
        <a href="#" class="block mt-2 bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
      </div>
    </div>
  </div>

  <!-- Tambah Modal -->
  <div x-data="{ showModal: false }">
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white text-black rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Tambah Data Produk</h2>
        <form action="tambah_produk1.php" method="POST" enctype="multipart/form-data">
          <label class="block mb-2">Nama Produk</label>
          <input type="text" name="nama_produk" required class="w-full border px-3 py-2 rounded mb-4">

          <label class="block mb-2">Harga Produk</label>
          <input type="text" name="harga_produk" required class="w-full border px-3 py-2 rounded mb-4">

          <label class="block mb-2">Stock</label>
          <input type="number" name="stok" required class="w-full border px-3 py-2 rounded mb-4">

          <label class="block mb-2">Gambar Produk</label>
          <input type="file" name="gambar_produk" required class="w-full mb-4">

          <div class="flex justify-end space-x-2">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-400 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-indigo-600 text-center py-4">
    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
      <img src="btc.png" class="w-20">
      <p class="text-sm">Nikmati kemudahan top-up diamond game favorit Anda menggunakan BTC Top Up Game Store!</p>
    </div>
    <p class="text-sm mt-2">&copy; 2025 BTC Top Up Game Store. All Rights Reserved.</p>
  </footer>
</body>

</html>
