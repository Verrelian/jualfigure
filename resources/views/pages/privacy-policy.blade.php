@extends('layout.app')

@section('title', 'Kebijakan Privasi & Syarat Penggunaan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 text-gray-800">
    <h1 class="text-3xl font-bold mb-6 text-center text-primary">Kebijakan Privasi & Syarat Penggunaan</h1>

    <div class="space-y-8 text-justify leading-relaxed">
        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">1. Pengumpulan Informasi</h2>
            <p>Kami mengumpulkan informasi pribadi seperti nama, email, dan nomor telepon saat Anda mendaftar atau menghubungi kami. Informasi ini hanya digunakan untuk keperluan internal dan tidak akan dibagikan kepada pihak ketiga tanpa izin Anda.</p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">2. Penggunaan Data</h2>
            <p>Data yang kami kumpulkan digunakan untuk meningkatkan layanan, mengirimkan informasi terkait produk atau promosi, dan memberikan pengalaman pengguna yang lebih baik di platform kami.</p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">3. Keamanan</h2>
            <p>Kami menjaga keamanan informasi Anda dengan menerapkan protokol keamanan dan sistem enkripsi yang memadai untuk mencegah akses tidak sah.</p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">4. Cookies</h2>
            <p>Website kami menggunakan cookies untuk menganalisis perilaku pengguna dan meningkatkan performa. Anda dapat menonaktifkan cookies melalui pengaturan browser Anda.</p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">5. Syarat Penggunaan</h2>
            <p>Dengan mengakses dan menggunakan situs kami, Anda setuju untuk mematuhi semua ketentuan dan kebijakan yang berlaku. Kami berhak untuk mengubah kebijakan ini kapan saja tanpa pemberitahuan sebelumnya.</p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-primary mb-2">6. Kontak</h2>
            <p>Jika Anda memiliki pertanyaan mengenai kebijakan privasi atau penggunaan data, silakan hubungi kami melalui halaman <a href="{{ route('contact-us') }}" class="text-blue-600 underline hover:text-blue-800">Kontak</a>.</p>
        </section>
    </div>
</div>
@endsection
