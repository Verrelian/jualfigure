<footer class="bg-gray-900 text-white">

    <!-- Bottom -->
    <div class="bg-gray-950 py-6">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="flex space-x-6 md:order-2">
                <a href="/mole/contact-us" class="text-sm text-gray-400 hover:text-blue-400">Contact-us</a>
                <a href="/mole/ambabot" class="text-sm text-gray-400 hover:text-blue-400">FAQ</a>
            </div>
            <p class="mt-4 md:mt-0 text-sm text-gray-400 md:order-1">
                &copy; <span id="year"></span> M.O.L.E. All rights reserved.
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
