@extends('layout.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-blue-700 mb-2">Hubungi Kami</h1>
        <p class="text-gray-600">Silakan tinggalkan pesan Anda dan kami akan menghubungi Anda segera.</p>
    </div>

    <!-- Contact Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    placeholder="email@example.com"
                    required
                >
            </div>

            <!-- Telepon -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    placeholder="0812 3456 7890"
                >
                <p class="mt-1 text-xs text-gray-500">Opsional, tetapi memudahkan kami untuk menghubungi Anda</p>
            </div>

            <!-- Subjek -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                <select
                    name="subject"
                    id="subject"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    required
                >
                    <option value="" disabled selected>Pilih subjek pesan</option>
                    <option value="general">Pertanyaan Umum</option>
                    <option value="order">Informasi Pesanan</option>
                    <option value="return">Pengembalian Produk</option>
                    <option value="complaint">Keluhan</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>

            <!-- Pesan -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea
                    name="message"
                    id="message"
                    rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                    placeholder="Tulis pesan Anda di sini..."
                    required
                ></textarea>
            </div>

            <!-- Persetujuan -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        required
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-600">
                        Saya menyetujui <a href="#" class="text-blue-600 hover:underline">kebijakan privasi</a> dan izin untuk menyimpan data kontak saya
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button
                    type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                >
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Kontak -->
    <div class="mt-12 grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="text-blue-600 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Telepon</h3>
            <p class="text-gray-600">0812-3456-7890</p>
            <p class="text-gray-600">Senin - Jumat, 09:00 - 17:00</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="text-blue-600 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Email</h3>
            <p class="text-gray-600">cs@namawebsiteanda.com</p>
            <p class="text-gray-600">Respon dalam 24 jam</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="text-blue-600 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Alamat</h3>
            <p class="text-gray-600">Jl. Contoh No. 123</p>
            <p class="text-gray-600">Jakarta Selatan, 12345</p>
        </div>
    </div>
</div>

<script>
    // Script untuk validasi form (opsional)
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            // Di sini Anda bisa menambahkan validasi custom
            // Misalnya validasi format nomor telepon Indonesia
            const phone = document.getElementById('phone');

            if (phone.value && !(/^(\+62|62|0)[0-9]{9,12}$/.test(phone.value.replace(/[\s-]/g, '')))) {
                e.preventDefault();
                alert('Nomor telepon tidak valid. Silakan masukkan nomor telepon Indonesia yang valid.');
                phone.focus();
            }
        });
    });
</script>
@endsection