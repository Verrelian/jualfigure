<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="btc.png" type="image/x-icon">
  <title>BTC Top Up Game Store</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .banner {
      background-image: url('banner.jpg');
    }
  </style>
</head>

<body class="bg-indigo-900 text-white overflow-x-hidden pt-[150px]">
  <!-- Side Menu Button -->
  <button class="fixed top-4 left-4 z-50 bg-indigo-800 hover:bg-indigo-500 text-white text-2xl px-4 py-2 rounded" onclick="document.getElementById('sidebar').classList.remove('hidden')">
    ☰
  </button>

  <!-- Sidebar -->
  <div id="sidebar" class="fixed top-0 left-0 w-72 h-full bg-indigo-800 text-white z-50 hidden">
    <div class="flex items-center justify-between p-4">
      <img src="btc.png" alt="BTC Logo" class="w-24">
      <button class="text-white text-2xl" onclick="document.getElementById('sidebar').classList.add('hidden')">&times;</button>
    </div>
    <nav class="flex flex-col px-6 space-y-4">
      <a href="dashboard.php" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-home"></i><span>HOME</span>
      </a>
      <a href="list_of_games.php" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-gamepad"></i><span>LIST OF GAMES</span>
      </a>
      <a href="profile.php" class="text-white text-lg hover:bg-white/10 rounded px-3 py-2 flex items-center space-x-2">
        <i class="fas fa-user"></i><span>ACCOUNT</span>
      </a>
    </nav>
  </div>

  <!-- Header -->
  <header class="fixed top-0 w-full bg-indigo-800 p-4 flex items-center justify-between z-40">
    <div class="flex items-center gap-4 ml-8">
      <img src="btc.png" alt="BTC Logo" class="w-24">
      <div class="bg-white text-black rounded-full px-4 py-2 w-[500px]">
        <input id="searchInput" type="text" placeholder="Search Game" class="w-full bg-transparent border-none focus:outline-none font-semibold">
      </div>
    </div>
  </header>

  <!-- Search Popup -->
  <div id="searchOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>
  <div id="searchPopup" class="hidden fixed top-20 left-1/2 transform -translate-x-1/2 bg-indigo-950 bg-opacity-90 p-6 rounded-xl w-11/12 max-w-3xl max-h-[80vh] overflow-y-auto z-40">
    <div class="flex items-center mb-4">
      <svg class="w-6 h-6 mr-2 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      <h3 id="searchTerm" class="text-xl font-semibold"></h3>
    </div>
    <div id="searchResults" class="flex flex-col gap-4">
      <!-- Search results will appear here -->
    </div>
  </div>

  <!-- Banner -->
  <section class="banner relative h-[300px] bg-cover bg-center rounded-2xl mx-auto my-8 w-11/12 max-w-4xl animate-[jumpOutEffect_1s_ease-out_forwards]">
    <h1 class="text-4xl font-bold text-white drop-shadow-md absolute inset-0 flex items-center justify-center">BTC Top Up Game Store</h1>
  </section>

  <!-- Divider -->
  <div class="py-6 border-b-2 border-white w-full">
    <h2 class="text-2xl font-bold ml-24">Daftar Game</h2>
  </div>

  <!-- Game List -->
  <section class="flex justify-center gap-10 flex-wrap my-8">
    <div class="w-48 text-center relative">
      <a href="produk1_pembeli.php" class="block">
        <img src="pubg.jpg" alt="PUBG" class="w-full rounded-lg transition duration-300 hover:blur-sm">
        <div class="absolute inset-0 flex flex-col justify-end p-2 opacity-0 hover:opacity-100 transition duration-300">
          <h2 class="text-lg font-bold">PUBG Mobile</h2>
          <p class="text-sm text-white/80">Tencent Games</p>
        </div>
      </a>
    </div>
    <div class="w-48 text-center relative">
      <a href="produk2_pembeli.php" class="block">
        <img src="mobile_legends.jpg" alt="Mobile Legends" class="w-full rounded-lg transition duration-300 hover:blur-sm">
        <div class="absolute inset-0 flex flex-col justify-end p-2 opacity-0 hover:opacity-100 transition duration-300">
          <h2 class="text-lg font-bold">Mobile Legends</h2>
          <p class="text-sm text-white/80">Moonton</p>
        </div>
      </a>
    </div>
    <div class="w-48 text-center relative">
      <a href="produk3_pembeli.php" class="block">
        <img src="freefire.jpg" alt="Free Fire" class="w-full rounded-lg transition duration-300 hover:blur-sm">
        <div class="absolute inset-0 flex flex-col justify-end p-2 opacity-0 hover:opacity-100 transition duration-300">
          <h2 class="text-lg font-bold">Free Fire</h2>
          <p class="text-sm text-white/80">Garena</p>
        </div>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-indigo-600 text-center text-white py-6">
    <div class="flex flex-col items-center gap-2">
      <img src="btc.png" alt="BTC Logo" class="w-20">
      <p class="max-w-xl px-4">Nikmati kemudahan top-up diamond game favorit Anda menggunakan BTC Top Up Game Store!</p>
      <p class="text-sm">&copy; 2025 BTC Top Up Game Store</p>
    </div>
  </footer>
</body>

</html>
