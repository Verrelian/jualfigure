@forelse($orders as $order)
<tr class="text-center border-b hover:bg-gray-50">
    <td class="text-sm text-left py-2 px-4">{{ $order->order_id }}</td>
    <td class="text-sm text-left py-2 px-4">{{ $order->product_name }}</td>
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
@empty
<tr>
    <td colspan="5" class="text-center text-gray-500 py-4">
        <p class="text-gray-500">No orders found in this section.</p>
    </td>
</tr>
@endforelse