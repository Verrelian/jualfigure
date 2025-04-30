@extends('layout.apps')

@section('content')
<div class="flex min-h-screen">
  <!-- Sidebar -->
  @include('component.seller.sidebar')

  <!-- Main Content -->
  <main class="flex-1 bg-gray-100 p-6">
    <h1 class="text-2xl font-semibold mb-4">Kelola Pesanan</h1>

    <!-- Tabel Pesanan -->
    <div class="bg-white p-4 rounded shadow">
      <table class="min-w-full text-left text-sm">
        <thead>
          <tr class="border-b">
            <th class="py-2 px-4 font-medium">Order ID</th>
            <th class="py-2 px-4 font-medium">Pelanggan</th>
            <th class="py-2 px-4 font-medium">Tanggal</th>
            <th class="py-2 px-4 font-medium">Total</th>
            <th class="py-2 px-4 font-medium">Status</th>
            <th class="py-2 px-4 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody id="orderTableBody">
          <!-- Data pesanan akan ditampilkan di sini -->
        </tbody>
      </table>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">Detail Pesanan <span id="modalOrderId"></span></h2>
          <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="mb-6">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <p class="text-sm text-gray-600">Pelanggan</p>
              <p id="modalCustomerName" class="font-semibold"></p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Tanggal Pesanan</p>
              <p id="modalOrderDate" class="font-semibold"></p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <p id="modalOrderStatus" class="font-semibold"></p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Pesanan</p>
              <p id="modalOrderTotal" class="font-semibold"></p>
            </div>
          </div>

          <div>
            <p class="text-sm text-gray-600 mb-2">Alamat Pengiriman</p>
            <p id="modalShippingAddress" class="text-sm"></p>
          </div>
        </div>

        <div class="mb-6">
          <h3 class="font-semibold mb-2">Item Pesanan</h3>
          <div class="bg-gray-50 p-3 rounded">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b">
                  <th class="py-2 text-left">Produk</th>
                  <th class="py-2 text-center">Jumlah</th>
                  <th class="py-2 text-right">Harga</th>
                  <th class="py-2 text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody id="modalOrderItems">
                <!-- Item pesanan akan ditampilkan di sini -->
              </tbody>
              <tfoot class="border-t">
                <tr>
                  <td colspan="3" class="py-2 text-right font-semibold">Total:</td>
                  <td id="modalItemsTotal" class="py-2 text-right font-semibold"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="flex justify-end gap-2" id="modalActionButtons">
          <!-- Tombol aksi akan ditampilkan di sini sesuai status -->
        </div>
      </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Konfirmasi Tindakan</h2>

        <p id="confirmationMessage" class="mb-4"></p>

        <div class="flex justify-end gap-2">
          <button id="cancelConfirmation" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
          <button id="confirmAction" class="px-4 py-2 rounded"></button>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
// Data sampel pesanan (untuk simulasi)
let orders = [
  {
    id: 'ORD1024',
    customer: 'Budi Santoso',
    date: '30 Apr 2025',
    total: 250000,
    status: 'Menunggu Konfirmasi',
    address: 'Jl. Merdeka No. 123, Jakarta Selatan, DKI Jakarta 12345',
    items: [
      { name: 'Action Figure Naruto', qty: 1, price: 150000, subtotal: 150000 },
      { name: 'Manga One Piece Vol. 1', qty: 2, price: 50000, subtotal: 100000 }
    ]
  },
  {
    id: 'ORD1025',
    customer: 'Siti Rahayu',
    date: '29 Apr 2025',
    total: 450000,
    status: 'Diproses',
    address: 'Jl. Mawar No. 45, Bandung, Jawa Barat 40111',
    items: [
      { name: 'Nendoroid Hatsune Miku', qty: 1, price: 450000, subtotal: 450000 }
    ]
  },
  {
    id: 'ORD1026',
    customer: 'Ahmad Wijaya',
    date: '28 Apr 2025',
    total: 175000,
    status: 'Dikirim',
    address: 'Jl. Kenanga No. 78, Surabaya, Jawa Timur 60234',
    items: [
      { name: 'Manga Demon Slayer Vol. 1', qty: 1, price: 50000, subtotal: 50000 },
      { name: 'Poster Anime Premium', qty: 3, price: 25000, subtotal: 75000 },
      { name: 'Gantungan Kunci Anime', qty: 2, price: 25000, subtotal: 50000 }
    ]
  },
  {
    id: 'ORD1027',
    customer: 'Dewi Lestari',
    date: '27 Apr 2025',
    total: 325000,
    status: 'Selesai',
    address: 'Jl. Dahlia No. 15, Yogyakarta 55281',
    items: [
      { name: 'Figure Gojo Satoru', qty: 1, price: 250000, subtotal: 250000 },
      { name: 'Sticker Pack Anime', qty: 3, price: 25000, subtotal: 75000 }
    ]
  }
];

// Format angka sebagai Rupiah
function formatRupiah(angka) {
  return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Mendapatkan kelas warna berdasarkan status
function getStatusClass(status) {
  switch(status) {
    case 'Menunggu Konfirmasi':
      return 'bg-yellow-200 text-yellow-800';
    case 'Diproses':
      return 'bg-blue-200 text-blue-800';
    case 'Dikirim':
      return 'bg-purple-200 text-purple-800';
    case 'Selesai':
      return 'bg-green-200 text-green-800';
    case 'Dibatalkan':
      return 'bg-red-200 text-red-800';
    default:
      return 'bg-gray-200 text-gray-800';
  }
}

// Render tabel pesanan
function renderOrders() {
  const tableBody = document.getElementById('orderTableBody');
  tableBody.innerHTML = '';

  orders.forEach(order => {
    const row = document.createElement('tr');
    row.className = 'border-b hover:bg-gray-50';

    const statusClass = getStatusClass(order.status);

    // Tentukan tombol aksi berdasarkan status
    let actionButtons = `<button class="text-blue-600 hover:underline view-order" data-id="${order.id}">Lihat Detail</button> `;

    if (order.status === 'Menunggu Konfirmasi') {
      actionButtons += `
        <button class="text-green-600 hover:underline confirm-order ml-2" data-id="${order.id}">Konfirmasi</button>
        <button class="text-red-600 hover:underline cancel-order ml-2" data-id="${order.id}">Batalkan</button>
      `;
    } else if (order.status === 'Diproses') {
      actionButtons += `
        <button class="text-purple-600 hover:underline ship-order ml-2" data-id="${order.id}">Kirim</button>
      `;
    }

    row.innerHTML = `
      <td class="py-2 px-4">#${order.id}</td>
      <td class="py-2 px-4">${order.customer}</td>
      <td class="py-2 px-4">${order.date}</td>
      <td class="py-2 px-4">${formatRupiah(order.total)}</td>
      <td class="py-2 px-4">
        <span class="${statusClass} px-2 py-1 rounded text-xs">${order.status}</span>
      </td>
      <td class="py-2 px-4 space-x-2">
        ${actionButtons}
      </td>
    `;

    tableBody.appendChild(row);
  });

  // Tambahkan event listener untuk semua tombol
  addEventListeners();
}

// Tambahkan event listeners untuk tombol-tombol di tabel
function addEventListeners() {
  // Tombol lihat detail
  document.querySelectorAll('.view-order').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.getAttribute('data-id');
      openOrderDetailModal(orderId);
    });
  });

  // Tombol konfirmasi pesanan
  document.querySelectorAll('.confirm-order').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.getAttribute('data-id');
      confirmOrder(orderId);
    });
  });

  // Tombol batalkan pesanan
  document.querySelectorAll('.cancel-order').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.getAttribute('data-id');
      cancelOrder(orderId);
    });
  });

  // Tombol kirim pesanan
  document.querySelectorAll('.ship-order').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.getAttribute('data-id');
      shipOrder(orderId);
    });
  });
}

// Buka modal detail pesanan
function openOrderDetailModal(orderId) {
  const order = orders.find(o => o.id === orderId);
  if (!order) return;

  // Set informasi pesanan di modal
  document.getElementById('modalOrderId').textContent = '#' + order.id;
  document.getElementById('modalCustomerName').textContent = order.customer;
  document.getElementById('modalOrderDate').textContent = order.date;
  document.getElementById('modalOrderTotal').textContent = formatRupiah(order.total);
  document.getElementById('modalOrderStatus').textContent = order.status;
  document.getElementById('modalOrderStatus').className = getStatusClass(order.status) + ' px-2 py-1 rounded text-xs inline-block';
  document.getElementById('modalShippingAddress').textContent = order.address;
  document.getElementById('modalItemsTotal').textContent = formatRupiah(order.total);

  // Render item pesanan
  const itemsContainer = document.getElementById('modalOrderItems');
  itemsContainer.innerHTML = '';

  order.items.forEach(item => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td class="py-2">${item.name}</td>
      <td class="py-2 text-center">${item.qty}</td>
      <td class="py-2 text-right">${formatRupiah(item.price)}</td>
      <td class="py-2 text-right">${formatRupiah(item.subtotal)}</td>
    `;
    itemsContainer.appendChild(row);
  });

  // Set tombol aksi sesuai status
  const actionButtons = document.getElementById('modalActionButtons');
  actionButtons.innerHTML = '';

  // Tombol "Tutup" selalu ada
  const closeButton = document.createElement('button');
  closeButton.className = 'px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400';
  closeButton.textContent = 'Tutup';
  closeButton.addEventListener('click', closeDetailModal);
  actionButtons.appendChild(closeButton);

  // Tambahkan tombol sesuai status
  if (order.status === 'Menunggu Konfirmasi') {
    const confirmButton = document.createElement('button');
    confirmButton.className = 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 ml-2';
    confirmButton.textContent = 'Konfirmasi Pesanan';
    confirmButton.addEventListener('click', function() {
      closeDetailModal();
      confirmOrder(orderId);
    });
    actionButtons.appendChild(confirmButton);

    const cancelButton = document.createElement('button');
    cancelButton.className = 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2';
    cancelButton.textContent = 'Batalkan Pesanan';
    cancelButton.addEventListener('click', function() {
      closeDetailModal();
      cancelOrder(orderId);
    });
    actionButtons.appendChild(cancelButton);
  } else if (order.status === 'Diproses') {
    const shipButton = document.createElement('button');
    shipButton.className = 'px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 ml-2';
    shipButton.textContent = 'Kirim Pesanan';
    shipButton.addEventListener('click', function() {
      closeDetailModal();
      shipOrder(orderId);
    });
    actionButtons.appendChild(shipButton);
  }

  // Tampilkan modal
  document.getElementById('orderDetailModal').classList.remove('hidden');
  document.getElementById('orderDetailModal').classList.add('flex');
}

// Tutup modal detail pesanan
function closeDetailModal() {
  document.getElementById('orderDetailModal').classList.remove('flex');
  document.getElementById('orderDetailModal').classList.add('hidden');
}

// Konfirmasi pesanan
function confirmOrder(orderId) {
  openConfirmationModal(
    `Apakah Anda yakin ingin mengkonfirmasi pesanan #${orderId}?`,
    'Konfirmasi',
    'bg-green-600 text-white hover:bg-green-700',
    function() {
      // Update status pesanan
      const orderIndex = orders.findIndex(o => o.id === orderId);
      if (orderIndex !== -1) {
        orders[orderIndex].status = 'Diproses';
        renderOrders();
        closeConfirmationModal();
        alert(`Pesanan #${orderId} telah dikonfirmasi dan sedang diproses.`);
      }
    }
  );
}

// Batalkan pesanan
function cancelOrder(orderId) {
  openConfirmationModal(
    `Apakah Anda yakin ingin membatalkan pesanan #${orderId}?`,
    'Batalkan',
    'bg-red-600 text-white hover:bg-red-700',
    function() {
      // Update status pesanan
      const orderIndex = orders.findIndex(o => o.id === orderId);
      if (orderIndex !== -1) {
        orders[orderIndex].status = 'Dibatalkan';
        renderOrders();
        closeConfirmationModal();
        alert(`Pesanan #${orderId} telah dibatalkan.`);
      }
    }
  );
}

// Kirim pesanan
function shipOrder(orderId) {
  openConfirmationModal(
    `Apakah Anda yakin pesanan #${orderId} siap dikirim?`,
    'Kirim',
    'bg-purple-600 text-white hover:bg-purple-700',
    function() {
      // Update status pesanan
      const orderIndex = orders.findIndex(o => o.id === orderId);
      if (orderIndex !== -1) {
        orders[orderIndex].status = 'Dikirim';
        renderOrders();
        closeConfirmationModal();
        alert(`Pesanan #${orderId} telah dikirim.`);
      }
    }
  );
}

// Buka modal konfirmasi
function openConfirmationModal(message, buttonText, buttonClass, confirmCallback) {
  document.getElementById('confirmationMessage').textContent = message;

  const confirmButton = document.getElementById('confirmAction');
  confirmButton.textContent = buttonText;
  confirmButton.className = `px-4 py-2 ${buttonClass} rounded`;

  // Hapus event listener lama jika ada
  const newConfirmButton = confirmButton.cloneNode(true);
  confirmButton.parentNode.replaceChild(newConfirmButton, confirmButton);

  // Tambahkan event listener baru
  newConfirmButton.addEventListener('click', confirmCallback);

  // Tampilkan modal
  document.getElementById('confirmationModal').classList.remove('hidden');
  document.getElementById('confirmationModal').classList.add('flex');
}

// Tutup modal konfirmasi
function closeConfirmationModal() {
  document.getElementById('confirmationModal').classList.remove('flex');
  document.getElementById('confirmationModal').classList.add('hidden');
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
  // Render pesanan saat halaman dimuat
  renderOrders();

  // Tombol tutup di modal detail
  document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);

  // Tombol batal di modal konfirmasi
  document.getElementById('cancelConfirmation').addEventListener('click', closeConfirmationModal);
});
</script>
@endsection