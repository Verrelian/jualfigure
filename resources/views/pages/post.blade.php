@extends('layout.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Postingan Baru</h2>

    <!-- Form Postingan -->
    <form action="/mole/feed" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block font-semibold text-gray-700 mb-2">Judul Postingan</label>
            <input type="text" name="title" id="title" placeholder="Masukkan judul"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label for="description" class="block font-semibold text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="4" placeholder="Tulis deskripsi..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
        </div>

        <!-- Upload Gambar -->
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-2">Upload Gambar</label>
            <label for="image"
                class="flex items-center justify-center w-full h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-200 transition">
                <span class="text-3xl text-gray-500">+</span>
                <input type="file" name="image" id="image" class="hidden">
            </label>
        </div>

        <!-- Tombol Post -->
         <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
            Post
        </button>
    </form>
</div>
@endsection

