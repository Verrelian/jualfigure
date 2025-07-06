@extends('layout.apps')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          @forelse ($orders as $order)
          <tr class="border-b hover:bg-gray-50">
            <td class="py-2 px-4">{{ $order->order_id }}</td>
            <td class="py-2 px-4">{{ $order->name }}</td>
            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($order->payment_date)->format('d M Y') }}</td>
            <td class="py-2 px-4">Rp{{ number_format($order->price_total, 0, ',', '.') }}</td>
            <td class="py-2 px-4">
              @if ($order->payment_status === 'PAID' && $order->transaction_status === 'NOT YET PROCESSED')
              <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs">Waiting confirmation</span>
              @else
              @switch($order->transaction_status)
              @case('NOT YET PROCESSED')
              <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs">Waiting for payment</span>
              @break

              @case('PROCESSED')
              <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-xs">Processed</span>
              @break

              @case('SHIPPING')
              <span class="bg-orange-200 text-orange-800 px-2 py-1 rounded text-xs">Shipping</span>
              @break

              @case('DELIVERED')
              <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-xs">Delivered</span>
              @break

              @case('COMPLETED')
              <span class="bg-emerald-200 text-emerald-800 px-2 py-1 rounded text-xs">Completed</span>
              @break

              @case('CANCELED')
              <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs">Canceled</span>
              @break

              @case('EXPIRED')
              <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs">Expired</span>
              @break

              @default
              <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs">Unknown</span>
              @endswitch
              @endif
            </td>
            <td class="py-2 px-4 space-x-2">
              <button class="text-blue-600 hover:underline view-order" data-id="{{ $order->payment_id }}">View Detail</button>
              @if($order->payment_status === 'PAID' && $order->transaction_status === 'NOT YET PROCESSED')
              <button class="text-green-600 hover:underline confirm-order" data-id="{{ $order->payment_id }}">Confirm</button>
              <button class="text-red-600 hover:underline cancel-order" data-id="{{ $order->payment_id }}">Cancel</button>
              @endif
            </td>
          </tr>
          @if($order->transaction_status === 'PROCESSED')
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const paymentId = @json($order->payment_id);
              const csrfToken = @json(csrf_token());
              const readyAt = new Date("{{ \Carbon\Carbon::parse($order->shipping_ready_at)->format('Y-m-d H:i:s') }}");

              function checkShippingStatus() {
                const now = new Date();
                const diff = (now.getTime() - readyAt.getTime()) / 1000;

                console.log("Checking to-shipping... Diff:", diff);

                if (diff >= 10) {
                  fetch(`/mole/seller/to-shipping/${paymentId}`, {
                      method: 'POST',
                      headers: {
                        'X-CSRF-TOKEN': csrfToken
                      }
                    })
                    .then(res => res.json())
                    .then(data => {
                      console.log("Response:", data);
                      if (data.success) {
                        location.reload();
                      }
                    })
                    .catch(err => console.error("Fetch Error:", err));
                }
              }
              setInterval(checkShippingStatus, 3000);
            });
          </script>
          @endif
          @empty
          <tr>
            <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada pesanan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">Order Detail <span id="modalOrderId"></span></h2>
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
        <h2 class="text-xl font-semibold mb-4">Confirm Action</h2>
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
  function formatRupiah(angka) {
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function getStatusClass(status) {
    switch (status) {
      case 'Waiting for payment':
        return 'bg-yellow-200 text-gray-800';
      case 'Waiting confirmation':
        return 'bg-yellow-200 text-yellow-800';
      case 'Processed':
        return 'bg-blue-200 text-blue-800';
      case 'Shipping':
        return 'bg-orange-200 text-orange-800';
      case 'Delivered':
        return 'bg-blue-200 text-blue-800';
      case 'Completed':
        return 'bg-green-200 text-green-800';
      case 'Canceled':
        return 'bg-red-200 text-red-800';
      case 'Expired':
        return 'bg-red-200 text-red-800';
      default:
        return 'bg-gray-200 text-gray-800';
    }
  }

  function openOrderDetailModal(orderId) {
    fetch(`/mole/seller/order-detail/${orderId}`)
      .then(response => response.json())
      .then(order => {
        document.getElementById('modalOrderId').textContent = order.order_id;
        document.getElementById('modalCustomerName').textContent = order.name;
        document.getElementById('modalOrderDate').textContent = order.date;
        document.getElementById('modalOrderTotal').textContent = 'Rp' + order.total;
        document.getElementById('modalOrderStatus').textContent = order.display_status;
        document.getElementById('modalOrderStatus').className = getStatusClass(order.display_status) + ' px-2 py-1 rounded text-xs inline-block';
        document.getElementById('modalShippingAddress').textContent = order.address;
        document.getElementById('modalItemsTotal').textContent = 'Rp' + order.total;

        const itemsContainer = document.getElementById('modalOrderItems');
        itemsContainer.innerHTML = '';
        order.items.forEach(item => {
          const row = document.createElement('tr');
          row.innerHTML = `
          <td class="py-2">${item.name}</td>
          <td class="py-2 text-center">${item.qty}</td>
          <td class="py-2 text-right">Rp${item.price}</td>
          <td class="py-2 text-right">Rp${item.subtotal}</td>
        `;
          itemsContainer.appendChild(row);
        });

        const actionButtons = document.getElementById('modalActionButtons');
        actionButtons.innerHTML = '';

        const closeButton = document.createElement('button');
        closeButton.className = 'px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400';
        closeButton.textContent = 'Close';
        closeButton.addEventListener('click', closeDetailModal);
        actionButtons.appendChild(closeButton);

        if (order.display_status === 'Menunggu Konfirmasi') {
          const confirmButton = document.createElement('button');
          confirmButton.className = 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 ml-2';
          confirmButton.textContent = 'Konfirmasi Pesanan';
          confirmButton.addEventListener('click', function() {
            closeDetailModal();
            confirmOrder(order.order_id);
          });
          actionButtons.appendChild(confirmButton);

          const cancelButton = document.createElement('button');
          cancelButton.className = 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2';
          cancelButton.textContent = 'Batalkan Pesanan';
          cancelButton.addEventListener('click', function() {
            closeDetailModal();
            cancelOrder(order.order_id);
          });
          actionButtons.appendChild(cancelButton);
        }

        document.getElementById('orderDetailModal').classList.remove('hidden');
        document.getElementById('orderDetailModal').classList.add('flex');
      });
  }

  function closeDetailModal() {
    document.getElementById('orderDetailModal').classList.remove('flex');
    document.getElementById('orderDetailModal').classList.add('hidden');
  }

  document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);

  function confirmOrder(orderId) {
    Swal.fire({
      icon: 'question',
      title: 'Confirm Order ?',
      text: 'Are you sure you want to process this order ?',
      showCancelButton: true,
      confirmButtonText: 'Yes, Process',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded',
        cancelButton: 'bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded'
      }
    }).then(result => {
      if (result.isConfirmed) {
        fetch(`/mole/seller/order/${orderId}/process`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
            }
          })
          .then(async (res) => {
            const data = await res.json();

            if (!res.ok) {
              return Swal.fire({
                icon: 'error',
                title: 'Failed to confirm',
                text: data.error || 'An error occurred when processing the order.',
                customClass: {
                  confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
                }
              });
            }

            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order successfully confirmed !',
              customClass: {
                confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
              }
            }).then(() => {
              location.reload();
            });
          })
          .catch(() => {
            Swal.fire({
              icon: 'error',
              title: 'Oops!',
              text: 'Failed to connect to server.'
            });
          });
      }
    });
  }

  function cancelOrder(orderId) {
    Swal.fire({
      icon: 'warning',
      title: 'Cancel Order ?',
      text: 'This action cannot be undone. Are you sure you want to continue ?',
      showCancelButton: true,
      confirmButtonText: 'Yes, Cancel',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded',
        cancelButton: 'bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded'
      }
    }).then(result => {
      if (result.isConfirmed) {
        fetch(`/mole/seller/order/${orderId}/cancel`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
            }
          })
          .then(async res => {
            const data = await res.json();

            if (!res.ok) {
              return Swal.fire({
                icon: 'error',
                title: 'Failed to cancel',
                text: data.error || 'An error occurred when canceling the order.',
                customClass: {
                  confirmButton: 'bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded'
                }
              });
            }

            Swal.fire({
              icon: 'success',
              title: 'Order canceled',
              text: 'Order canceled successfully.',
              customClass: {
                confirmButton: 'bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded'
              }
            }).then(() => {
              location.reload();
            });
          })
          .catch(() => {
            Swal.fire({
              icon: 'error',
              title: 'Oops!',
              text: 'Failed to connect to server.'
            });
          });
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    addEventListeners();
  });

  function addEventListeners() {
    // Lihat detail
    document.querySelectorAll('.view-order').forEach(button => {
      button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        openOrderDetailModal(orderId); // panggil fungsi tampil detail
      });
    });

    // Konfirmasi
    document.querySelectorAll('.confirm-order').forEach(button => {
      button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        confirmOrder(orderId);
      });
    });

    // Batalkan
    document.querySelectorAll('.cancel-order').forEach(button => {
      button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        cancelOrder(orderId);
      });
    });
  }
</script>
@endsection