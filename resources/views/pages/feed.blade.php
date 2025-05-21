@extends('layout.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Feed Postingan</h2>

    <!-- Contoh 1 Post -->
    <div class="bg-white shadow-md rounded-lg p-4 flex flex-col md:flex-row items-center md:items-start md:justify-between gap-6">
        <!-- Kiri: Judul & Deskripsi -->
        <div class="flex-1 text-left">
            <h3 class="text-xl font-bold text-gray-900">Ini judul</h3>
            <p class="text-gray-700 mt-2">Ini adalah deskripsi.</p>
        </div>

        <!-- Kanan: Gambar -->
        <div class="w-full md:w-1/3">
            <img src="figure4.jpg" alt="Gambar Postingan"
                 class="w-full h-auto rounded-lg object-cover">
        </div>
    </div>

    <!-- Tambahkan lebih banyak post di bawah ini dengan struktur yang sama -->
</div>
@endsection
