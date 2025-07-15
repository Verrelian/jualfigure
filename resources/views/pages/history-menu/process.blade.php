@extends('layout.history-menu')

@section('title', 'Process')

@section('historyContent')
<div class="bg-white p-4 rounded shadow">
    <table class="min-w-full text-left text-sm table-fixed">
        <thead>
            <tr class="border-b">
                <th class="py-2 px-4 font-medium w-40">Order ID</th>
                <th class="py-2 px-4 font-medium w-60">Product</th>
                <th class="py-2 px-4 font-medium w-52">Order Date</th>
                <th class="py-2 px-4 font-medium w-56">Status</th>
            </tr>
        </thead>
        <tbody id="process-fetch">
            @forelse($orders as $order)
            <tr class="text-center border-b hover:bg-gray-50">
                <td class="text-sm text-left py-2 px-4">{{ $order->order_id }}</td>
                <td class="text-sm text-left py-2 px-4">
                    {{ $order->product_name }}
                    @if ($order->extra_count > 0)
                    <br><span class="text-gray-500 text-sm">+{{ $order->extra_count }}</span>
                    @endif
                </td>
                <td class="text-sm text-left py-2 px-4">{{ \Carbon\Carbon::parse($order->payment_date)->format('d M Y H:i') }}</td>
                <td class="text-sm text-left py-2 px-4">
                    <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-200 text-blue-800 rounded">
                        {{ $order->transaction_status === 'PROCESSED' ? 'Processed' : 'Waiting for Seller to Process' }}
                    </span>
                </td>
                <td class="py-2 px-4 space-x-2">
                    <a href="{{ route('history.process.detail', ['payment_id' => $order->payment_id]) }}"
                        class="ml-16 inline-block text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        View
                    </a>
                </td>
            </tr>
            <tr>
                @empty
                <td colspan="5" class="text-center text-gray-500 py-4">
                    <p class="text-gray-500">No orders found in this section.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<script>
    function fetchProcessOrders() {
        const container = document.getElementById('process-fetch');

        fetch('{{ route("process.fetch") }}', {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    console.warn('Fetch failed:', response.status);
                    return '';
                }
                return response.text();
            })
            .then(data => {
                if (data) {
                    container.innerHTML = data;

                    const hasOrders = container.querySelectorAll('tr').length > 1;
                    if (!hasOrders && window.fetchProcessInterval) {
                        clearInterval(window.fetchProcessInterval);
                        window.fetchProcessInterval = null;
                        console.log("Auto-fetch stopped — no more orders.");
                    }
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    function autoConvertProcessedToShipping() {
        fetch('/mole/process/auto-shipping', {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.updated > 0) {
                    console.log(`Moved ${data.updated} orders to SHIPPING`);
                }
            })
            .catch(err => {
                console.error("Failed to auto convert to shipping:", err);
            });
    }

    // Mulai interval
    document.addEventListener('DOMContentLoaded', function() {
        window.fetchProcessInterval = setInterval(() => {
            autoConvertProcessedToShipping();
            fetchProcessOrders();
        }, 3000);
    });
</script>

@endsection