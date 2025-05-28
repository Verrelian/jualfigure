@extends('layout.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-blue-700 mb-2">Pusat Bantuan</h1>
        <p class="text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan di bawah ini.</p>
    </div>

    <!-- FAQ Container -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- FAQ Item 1 -->
        <div class="faq-item border-b border-gray-200">
            <div class="faq-question py-4 px-5 bg-white text-blue-700 font-medium cursor-pointer flex justify-between items-center hover:bg-blue-50 transition-colors">
                <span>Bagaimana cara melakukan pemesanan?</span>
                <span class="text-xl">+</span>
            </div>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-out">
                <div class="p-5 text-gray-700">
                    <p>Untuk melakukan pemesanan, ikuti langkah-langkah berikut:</p>
                    <ol class="list-decimal pl-5 mt-2 space-y-1">
                        <li>Pilih produk yang ingin Anda beli</li>
                        <li>Klik tombol "Tambah ke Keranjang"</li>
                        <li>Buka keranjang belanja Anda dan klik "Lanjutkan ke Pembayaran"</li>
                        <li>Isi informasi pengiriman dan pembayaran</li>
                        <li>Klik "Konfirmasi Pesanan"</li>
                    </ol>
                    <p class="mt-2">Anda akan menerima email konfirmasi pesanan setelah berhasil melakukan pemesanan.</p>
                </div>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-item border-b border-gray-200">
            <div class="faq-question py-4 px-5 bg-white text-blue-700 font-medium cursor-pointer flex justify-between items-center hover:bg-blue-50 transition-colors">
                <span>Berapa lama waktu pengiriman?</span>
                <span class="text-xl">+</span>
            </div>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-out">
                <div class="p-5 text-gray-700">
                    <p>Waktu pengiriman tergantung pada lokasi Anda:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Wilayah Jabodetabek: 1-2 hari kerja</li>
                        <li>Kota besar di Pulau Jawa: 2-3 hari kerja</li>
                        <li>Luar Pulau Jawa: 3-5 hari kerja</li>
                        <li>Daerah terpencil: 5-7 hari kerja</li>
                    </ul>
                    <p class="mt-2">Perhatikan bahwa waktu pengiriman dapat berubah saat periode liburan atau situasi khusus lainnya.</p>
                </div>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-item">
            <div class="faq-question py-4 px-5 bg-white text-blue-700 font-medium cursor-pointer flex justify-between items-center hover:bg-blue-50 transition-colors">
                <span>Bagaimana kebijakan pengembalian produk?</span>
                <span class="text-xl">+</span>
            </div>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-out">
                <div class="p-5 text-gray-700">
                    <p>Kami menerima pengembalian produk dengan ketentuan berikut:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Produk belum digunakan dan dalam kondisi asli</li>
                        <li>Pengembalian dilakukan dalam waktu 7 hari setelah produk diterima</li>
                        <li>Sertakan bukti pembelian (invoice/nota)</li>
                        <li>Biaya pengiriman untuk pengembalian ditanggung oleh pembeli</li>
                    </ul>
                    <p class="mt-2">Untuk mengajukan pengembalian, silakan hubungi tim layanan pelanggan kami melalui email di <strong>cs@namawebsiteanda.com</strong> atau melalui formulir kontak di halaman Hubungi Kami.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi tambahan (jika diperlukan) -->
    <div class="text-center mt-8 text-sm text-gray-500">
        <p>Tidak menemukan jawaban yang Anda cari?</p>
        <p>Hubungi kami di <strong>cs@namawebsiteanda.com</strong> atau telepon <strong>0812-3456-7890</strong></p>
    </div>
</div>

<script>
    // Fungsi untuk mengelola FAQ dengan Tailwind
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = question.querySelector('span:last-child');

            question.addEventListener('click', () => {
                // Tutup semua item lain
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.querySelector('.faq-answer').classList.contains('max-h-96')) {
                        const otherAnswer = otherItem.querySelector('.faq-answer');
                        const otherIcon = otherItem.querySelector('.faq-question span:last-child');

                        otherAnswer.classList.remove('max-h-96');
                        otherAnswer.classList.add('max-h-0');

                        if (otherIcon) {
                            otherIcon.textContent = '+';
                        }
                    }
                });

                // Toggle item yang diklik
                answer.classList.toggle('max-h-0');
                answer.classList.toggle('max-h-96');

                if (icon) {
                    icon.textContent = answer.classList.contains('max-h-96') ? '−' : '+';
                }
            });
        });
    });
</script>
@endsection