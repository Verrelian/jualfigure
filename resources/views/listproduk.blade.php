@extends('layout.app')
@section('content')
<!--<div class ="ml-10 mt-20">
    @foreach ($nama as $index => $item)
    Nama Produk {{$index + 1}}: {{ $item}} <br>
    Deskripsi Produk {{$index + 1}}: {{ $desc[$index]}} <br>
    Harga Produk {{$index + 1}}: {{ $harga[$index]}} <br>
    @endforeach
</div>
-->

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    Color
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nama as $index => $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $item }}</td>
                <td class="px-6 py-4">{{ $desc[$index] ?? '-' }}</td>
                <td class="px-6 py-4">Rp {{ number_format($harga[$index] ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection