<footer class="bg-gray-900 text-white">
    <!-- Top Section -->
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:py-16 lg:px-8">
        <div class="xl:grid xl:grid-cols-4 xl:gap-8">
            <!-- Brand & Description -->
            <div class="xl:col-span-1 space-y-8">
                <div>
                    <a href="#" class="flex items-center">
                        <svg class="h-10 w-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="ml-3 text-xl font-bold">Brand Name</span>
                    </a>
                </div>
                <p class="text-gray-400 text-sm leading-6">
                    Kami berkomitmen untuk menyediakan produk berkualitas tinggi dengan pelayanan terbaik.
                </p>
                <div class="flex space-x-6">
                    <!-- Icons -->
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><!-- Facebook icon --></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><!-- Instagram icon --></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><!-- Twitter icon --></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><!-- YouTube icon --></svg>
                    </a>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-3">
                <div>
                    <h3 class="text-sm font-semibold uppercase">Produk</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Produk Terbaru</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Produk Terlaris</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Katalog Produk</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase">Bantuan</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase">Perusahaan</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase">Legal</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400">Privasi</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom -->
    <div class="bg-gray-950 py-6">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="flex space-x-6 md:order-2">
                <a href="#" class="text-sm text-gray-400 hover:text-blue-400">Sitemap</a>
                <a href="#" class="text-sm text-gray-400 hover:text-blue-400">FAQ</a>
            </div>
            <p class="mt-4 md:mt-0 text-sm text-gray-400 md:order-1">
                &copy; <span id="year"></span> Brand Name. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Back to Top -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg scale-0 transition-transform duration-300 hover:bg-blue-700 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7 7 7M12 3v18"/>
        </svg>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const year = document.getElementById('year');
            year.textContent = new Date().getFullYear();

            const backToTopButton = document.getElementById('back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopButton.classList.remove('scale-0');
                    backToTopButton.classList.add('scale-100');
                } else {
                    backToTopButton.classList.remove('scale-100');
                    backToTopButton.classList.add('scale-0');
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
</footer>
