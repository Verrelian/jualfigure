<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/logo.jpeg" type="image/x-icon">
  <title>MOLE - Anime Figure Collection</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f0f0f0;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 overflow-x-hidden pt-16">

  <!-- Header with integrated hamburger menu and search -->
  <header class="fixed top-0 left-0 right-0 flex items-center justify-between px-4 py-3 bg-white shadow-md z-40">
    <div class="container mx-auto pt-20">
      <button aria-label="Open Menu" class="text-gray-700 hover:text-blue-500" onclick="document.getElementById('sidebar').classList.remove('hidden')">
        <i class="fas fa-bars text-xl"></i>
      </button>
      <img src="image/logo.jpeg" alt="MOLE Logo" class="w-8 h-8 rounded-full">
      <span class="text-xl font-bold">MOLE</span>
    </div>
    <div class="flex items-center gap-2 w-1/2 max-w-md">
      <div class="relative w-full">
        <input type="text" placeholder="search" class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none text-gray-700 bg-gray-100">
        <button class="absolute right-3 top-2 text-gray-500">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Sidebar -->
  <div id="sidebar" class="fixed top-0 left-0 w-72 h-full bg-gray-800 text-white z-50 hidden">
    <div class="flex items-center justify-between p-4">
      <div class="flex items-center">
        <img src="{{ asset('image/logo.jpeg') }}" alt="MOLE Logo" class="w-12 h-12 rounded-full">
        <span class="text-xl font-bold ml-2">MOLE</span>
      </div>
      <button class="text-white text-2xl" onclick="document.getElementById('sidebar').classList.add('hidden')">&times;</button>
    </div>
    <nav class="flex flex-col px-6 space-y-4">
      <a href="index.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-home"></i><span>HOME</span>
      </a>
      <a href="collections.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-bookmark"></i><span>Whislist</span>
      </a>
      <a href="profile.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-user"></i><span>ACCOUNT</span>
      </a>
      <a href="cart.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fa-solid fa-star"></i><span>Leaderboard</span>
      </a>
      <a href="cart.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fa-brands fa-android"></i><span>AMBot</span>
      </a>
      <a href="cart.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fa-solid fa-store"></i><span>Explore Store</span>
      <a href="cart.html" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fa-solid fa-eye"></i><span>FeedPOST</span>
      </a>
    </nav>
  </div>

  <!-- Banner -->
  <section class="relative w-full h-48 overflow-hidden">
    <img src="image/banner.jpeg" alt="Find your Dream Figure Collection!" class="w-full h-full object-cover">
    <div class="absolute inset-0 flex items-center justify-center">
      <h1 class="text-4xl font-bold text-black drop-shadow-lg">Find your Dream Figure Collection!</h1>
    </div>
  </section>

  <!-- Product Rankings Section -->
  <section class="bg-gray-200 py-6 px-4 mt-4">
  <div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4 text-gray-700">Product Ranking</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2 overflow-x-auto">
      <!-- Product Items - Row 1 -->
      <div class="bg-white rounded-lg shadow p-2">
        <div class="w-full aspect-square bg-white flex items-center justify-center overflow-hidden rounded">
          <img src="image/p5.jpg" alt="Anime Figure" class="w-full h-auto object-cover object-center rounded">
        </div>
        <p class="text-xs mt-2 text-gray-600 line-clamp-2 h-10">[REVIVE] PVC Figure Stardust Dragon - Yu-Gi-Oh! 5D's (30cm)</p>
        <p class="text-xs font-bold text-blue-600">Rp 5.850.000</p>
      </div>
      <div class="bg-white rounded-lg shadow p-2">
        <div class="w-full aspect-square bg-white flex items-center justify-center overflow-hidden rounded">
          <img src="image/p4.jpg" alt="Anime Figure" class="w-full h-auto object-cover object-center rounded">
        </div>
        <p class="text-xs mt-2 text-gray-600 line-clamp-2 h-10">[REVIVE] S.H.MonsterArts Red Eyes Black Dragon - Yu-Gi-Oh! Duel Monsters</p>
        <p class="text-xs font-bold text-blue-600">Rp 2.750.000</p>
      </div>
      <div class="bg-white rounded-lg shadow p-2">
        <div class="w-full aspect-square bg-white flex items-center justify-center overflow-hidden rounded">
          <img src="image/p2.jpg" alt="Anime Figure" class="w-full h-auto object-cover object-center rounded">
        </div>
        <p class="text-xs mt-2 text-gray-600 line-clamp-2 h-10">Pop Up Parade Figure Gawr Gura - hololive production</p>
        <p class="text-xs font-bold text-blue-600">Rp 920.000</p>
      </div>
      <div class="bg-white rounded-lg shadow p-2">
        <div class="w-full aspect-square bg-white flex items-center justify-center overflow-hidden rounded">
          <img src="image/p3.jpg" alt="Anime Figure" class="w-full h-auto object-cover object-center rounded">
        </div>
        <p class="text-xs mt-2 text-gray-600 line-clamp-2 h-10">Nendoroid Aventurine / Kakavasha - Honkai: Star Rail</p>
        <p class="text-xs font-bold text-blue-600">Rp 200.000</p>
      </div>
      <div class="bg-white rounded-lg shadow p-2">
        <div class="w-full aspect-square bg-white flex items-center justify-center overflow-hidden rounded">
          <img src="image/p1.jpg" alt="Anime Figure" class="w-full h-autO object-cover">
        </div>
        <p class="text-xs mt-2 text-gray-600 line-clamp-2 h-10">Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)</p>
        <p class="text-xs font-bold text-blue-600">Rp 500.000</p>
      </div>
    </div>
  </div>
</section>


  <!-- Product Items Section -->
  <section class="bg-gray-200 py-6 px-4 mt-4">
    <div class="container mx-auto">
      <h2 class="text-xl font-bold mb-4 text-gray-700">Product Items</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2 overflow-x-auto">
        <!-- Product Items - Row 2 -->
        <div class="bg-white rounded-lg shadow p-2">
          <img src="/api/placeholder/120/160" alt="Anime Figure" class="w-full h-32 object-cover object-center rounded">
          <p class="text-xs mt-1 text-gray-600">Fate/Stay Night Saber Figure</p>
          <p class="text-xs font-bold text-blue-600">Rp 850.000</p>
        </div>
        <div class="bg-white rounded-lg shadow p-2">
          <img src="/api/placeholder/120/160" alt="Anime Figure" class="w-full h-32 object-cover object-center rounded">
          <p class="text-xs mt-1 text-gray-600">Oregairu Yukinoshita Figure</p>
          <p class="text-xs font-bold text-blue-600">Rp 750.000</p>
        </div>
        <div class="bg-white rounded-lg shadow p-2">
          <img src="/api/placeholder/120/160" alt="Anime Figure" class="w-full h-32 object-cover object-center rounded">
          <p class="text-xs mt-1 text-gray-600">Demon Slayer Nezuko Figure</p>
          <p class="text-xs font-bold text-blue-600">Rp 920.000</p>
        </div>
        <div class="bg-white rounded-lg shadow p-2">
          <img src="/api/placeholder/120/160" alt="Anime Figure" class="w-full h-32 object-cover object-center rounded">
          <p class="text-xs mt-1 text-gray-600">Evangelion Rei Ayanami Figure</p>
          <p class="text-xs font-bold text-blue-600">Rp 1.200.000</p>
        </div>
        <div class="bg-white rounded-lg shadow p-2">
          <img src="/api/placeholder/120/160" alt="Anime Figure" class="w-full h-32 object-cover object-center rounded">
          <p class="text-xs mt-1 text-gray-600">Kimetsu no Yaiba Collection</p>
          <p class="text-xs font-bold text-blue-600">Rp 2.500.000</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Post Section -->
  <section class="bg-gray-200 py-6 px-4 mt-4">
    <div class="container mx-auto">
      <h2 class="text-xl font-bold mb-4 text-gray-700">Post</h2>
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row">
          <div class="w-full md:w-2/3">
            <h3 class="font-bold text-sm">New collections in designer boxes, beautiful and reasonable!</h3>
            <p class="text-xs mt-2">
              We're constantly updating our collection with the newest and most sought-after anime figures. Our products come in designer boxes that protect your collection and add value to your investment.
            </p>
            <p class="text-xs mt-2">
              Pre-orders are now open for the latest releases from popular series. Reserve yours today to avoid disappointment as quantities are limited!
            </p>
          </div>
          <div class="w-full md:w-1/3 mt-4 md:mt-0 md:pl-4">
            <div class="bg-green-500 p-2 rounded text-white text-center">
              <p class="font-bold">ECO FRIENDLINESS</p>
              <p class="text-xs">IN THE WORLD OF PREMIUM TOYS</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-center text-white py-6 mt-4">
    <div class="flex flex-col items-center gap-2">
      <img src="image/logo.jpeg" alt="MOLE Logo" class="w-12 h-12 rounded-full">
      <p class="max-w-xl px-4">Discover premium anime figures and collectibles at MOLE - your trusted source for authentic merchandise.</p>
      <p class="text-sm">&copy; 2025 MOLE Figure Collection</p>
    </div>
  </footer>

  <!-- Close Sidebar on Overlay Click -->
  <script>
    window.addEventListener('click', function (e) {
      const sidebar = document.getElementById('sidebar');
      if (!sidebar.contains(e.target) && !e.target.closest('button')) {
        sidebar.classList.add('hidden');
      }
    });
  </script>

</body>
</html>