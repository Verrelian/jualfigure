<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTC Top Up Game Store</title>
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/forms@0.5.6/dist/forms.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-indigo-900 text-white font-['Plus Jakarta Sans'] overflow-x-hidden pt-36">
    <!-- Header Section -->
    <button class="fixed top-4 left-4 z-50 bg-indigo-900 text-white text-2xl px-4 py-2 rounded" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
        ☰
    </button>

    <div id="offcanvasMenu" class="fixed top-0 left-0 w-72 h-full bg-indigo-800 z-40 p-6 hidden">
        <div class="flex justify-between items-center">
            <img src="btc.png" class="w-32" alt="BTC Logo">
            <button class="text-white text-xl" onclick="document.getElementById('offcanvasMenu').classList.add('hidden')">&times;</button>
        </div>
        <ul class="mt-8 space-y-4">
            <li><a href="dashboard_penjual.php" class="flex items-center gap-3 text-white hover:bg-white/10 px-3 py-2 rounded"><i class="fas fa-home"></i> HOME</a></li>
            <li><a href="list_of_gamesp.php" class="flex items-center gap-3 text-white bg-indigo-600 px-3 py-2 rounded"><i class="fas fa-gamepad"></i> LIST OF GAMES</a></li>
            <li><a href="profile_penjual.php" class="flex items-center gap-3 text-white hover:bg-white/10 px-3 py-2 rounded"><i class="fas fa-user"></i> ACCOUNT</a></li>
        </ul>
    </div>

    <header class="fixed top-0 left-0 right-0 bg-indigo-800 flex justify-between items-center px-6 py-4 z-30 w-full">
        <div class="flex items-center gap-4">
            <img src="btc.png" alt="BTC Logo" class="w-24">
            <div class="flex items-center bg-white text-black rounded-full px-4 py-2 w-96">
                <input id="searchInput" type="text" placeholder="Search Game" class="w-full border-none focus:ring-0 font-semibold bg-transparent">
            </div>
        </div>
    </header>

    <!-- Search Popup -->
    <div id="searchOverlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>
    <div id="searchPopup" class="fixed top-24 left-1/2 transform -translate-x-1/2 bg-slate-800/95 rounded-xl p-6 w-11/12 max-w-3xl z-50 hidden max-h-[80vh] overflow-y-auto">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <h3 id="searchTerm" class="text-white font-semibold text-lg"></h3>
        </div>
        <div id="searchResults" class="flex flex-col gap-4"></div>
    </div>

    <!-- Game List Section -->
    <section class="flex justify-center gap-10 my-10 flex-wrap">
        <!-- Game Item 1 -->
        <div class="relative w-52 text-center group">
            <a href="produk1_penjual.php">
                <img src="pubg.jpg" alt="PUBG" class="w-full rounded-lg transition group-hover:blur-sm">
                <div class="absolute inset-0 flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition">
                    <h2 class="text-lg font-bold">PUBG Mobile</h2>
                    <p class="text-sm text-white/90">Tencent Games</p>
                </div>
            </a>
        </div>

        <!-- Game Item 2 -->
        <div class="relative w-52 text-center group">
            <a href="produk2_penjual.php">
                <img src="mobile_legends.jpg" alt="Mobile Legends" class="w-full rounded-lg transition group-hover:blur-sm">
                <div class="absolute inset-0 flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition">
                    <h2 class="text-lg font-bold">Mobile Legends</h2>
                    <p class="text-sm text-white/90">Moonton</p>
                </div>
            </a>
        </div>

        <!-- Game Item 3 -->
        <div class="relative w-52 text-center group">
            <a href="produk3_penjual.php">
                <img src="freefire.jpg" alt="Free Fire" class="w-full rounded-lg transition group-hover:blur-sm">
                <div class="absolute inset-0 flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition">
                    <h2 class="text-lg font-bold">Free Fire</h2>
                    <p class="text-sm text-white/90">Garena</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-indigo-600 text-white text-center py-6 mt-10">
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
            <img src="btc.png" alt="BTC Logo" class="w-24">
            <p class="max-w-xl text-sm">Nikmati kemudahan top-up diamond game favorit Anda menggunakan BTC Top Up Game Store! Kami menghadirkan solusi modern untuk para gamer yang ingin mengisi saldo diamond dan UC dengan cepat.</p>
        </div>
        <p class="mt-4 text-xs">© 2025 BTC Top Up Game Store. All Right Reserved.</p>
    </footer>
</body>

</html>
