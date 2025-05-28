@extends('layout.app')
{{-- Menggunakan layout utama dari file layout.app --}}

@section('content')
{{-- Memulai section 'content' yang akan ditampilkan di dalam layout --}}

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    {{-- Container utama dengan styling Tailwind untuk scroll horizontal dan shadow --}}

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        {{-- Tabel dengan lebar penuh, teks kecil, rata kiri, dan dukungan dark mode --}}

        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
            {{-- Bagian kepala tabel (judul kolom) dengan huruf kapital --}}
            <tr>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    NO {{-- Kolom nomor urut --}}
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama {{-- Kolom nama produk --}}
                </th>
                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                    Deskripsi {{-- Kolom deskripsi produk --}}
                </th>
                <th scope="col" class="px-6 py-3">
                    Harga {{-- Kolom harga produk --}}
                </th>
            </tr>
        </thead>

        <tbody>
            {{-- Bagian isi data tabel --}}
            @foreach ($nama as $index => $item)
            {{-- Melakukan looping untuk setiap item di array $nama --}}
            <tr class="border-b border-gray-200 dark:border-gray-700">
                {{-- Setiap baris data dengan garis bawah pembatas --}}

                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                    {{ $index + 1 }}
                    {{-- Menampilkan nomor urut mulai dari 1 --}}
                </td>

                <td class="px-6 py-4">
                    {{ $item }}
                    {{-- Menampilkan nama produk --}}
                </td>

                <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    {{ $desc[$index] }}
                    {{-- Menampilkan deskripsi yang sesuai dengan index dari $nama --}}
                </td>

                <td class="px-6 py-4">
                    {{ $harga[$index] }}
                    {{-- Menampilkan harga yang sesuai dengan index dari $nama --}}
                </td>
            @endforeach
            {{-- Menutup perulangan foreach --}}
            </tr>
        </tbody>
    </table>
</div>

@endsection
{{-- Mengakhiri section 'content' --}}
