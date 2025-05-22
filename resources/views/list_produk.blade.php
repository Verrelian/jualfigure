@extends('layout.app')
@section('content')


<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    Deskripsi
                </th>
                <th scope="col" class="px-6 py-3">
                    Harga
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nama as $index => $item)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                {{ $index + 1 }}
                </td>
                <td class="px-6 py-4">
                {{ $item }}
                </td>
                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                {{ $desc[$index] }}
                </td>
                <td class="px-6 py-4">
                {{ $harga[$index] }}
                </td>
            @endforeach
            </tr>
        </tbody>
    </table>
</div> 
@endsection