<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="btc.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="styled.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">


  <title>BTC Top Up Game Store</title>

</head>

<style>
    /* General Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  padding-top: 150px; /* Sesuaikan dengan tinggi header */
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: #1A237E;
  color: #ffffff;
  overflow-x: hidden;
}

/* Header Styles */
.header-left {
  display: flex;
  margin-left: 60px;
  align-items: center;
}

.menu-icon {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 20px;
  height: 21px;
  cursor: pointer;
  margin-right: 40px;
  margin-left: 10px;
}

.menu-icon div {
  width: 150%;
  height: 3px;
  background-color: #ffffff;
  border-radius: 2px;
}

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 20px;
  background-color: #1a2373;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  width: 100%;
}

header img {
  width: 100px;
}

.search-bar {
  display: flex;
  align-items: center;
  width: 500px;
  margin-left: 15px;
  background-color: #ffffff;
  border-radius: 20px;
  padding: 5px 10px;
}

.search-bar input {
  font-weight: bold;
  width: 100%;
  padding: 8px;
  border-radius: 100px;
  border: none;
  margin-left: 10px;
  outline: none;
}

.custom-offcanvas {
  background-color: #1a2373;
  color: white;
  padding-left: 20px;
}

.logo {
  width: 120px;
  padding-left: 10px;
  padding-top: 10px;
}

.nav-link i {
  margin-right: 10px; /* Beri jarak antara ikon dan teks */
  font-size: 1.2rem; /* Ukuran ikon */
  vertical-align: middle; /* Pastikan ikon sejajar dengan teks */
}

.nav-link {
  font-size: 18px;
  padding: 10px 15px;
  margin: 5px 0;
  color: white;
  text-decoration: none;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 5px;
}

.nav-link.active {
  background-color: #5C6BC0;
  border-radius: 5px;
}

.offcanvas-header .btn-close {
  color: white;
}

.offcanvas-header .btn-close:hover {
  color: #5C6BC0;
  transform: scale(1.1);
  transition: transform 0.2s;
}

.offcanvas-body {
  display: flex;
  flex-direction: column;
  align-items: start;
}

.offcanvas.custom-offcanvas {
  width: 280px;
  max-width: 80%;
  background-color: #1a2373;
}

.offcanvas .offcanvas-body {
  padding: 1rem;
}

.offcanvas .nav-link {
  font-size: 16px;
  padding: 10px 0;
}

/* Button Styles */
.btn {
  background-color: #1a2373;
  border: none;
  color: white;
  font-size: 1.5rem;
  padding: 10px 15px;
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 1000;
}

.btn:hover {
  background-color: #5C6BC0;
}

/* Banner Styles */
.banner {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 300px;
  background-image: url('banner.jpg');
  background-size: cover;
  background-position: center;
  border-radius: 20px;
  margin: 20px auto;
  width: 80%;
  max-width: 800px;
  opacity: 0;
  transform: scale(0.8);
  animation: jumpOutEffect 1s ease-out forwards;
}

.banner h1 {
  font-size: 36px;
  font-weight: bold;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

@keyframes jumpOutEffect {
  0% {
    opacity: 0;
    transform: scale(0.8);
  }
  60% {
    opacity: 1;
    transform: scale(1.1);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.divider {
  padding: 20px 0;
  width: 100vw;
  max-width: none;
  border-bottom: 2px solid #ffffff;
}

.divider h2 {
  font-size: 24px;
  color: #ffffff;
  font-weight: bold;
  margin-left: 100px;
}

/* Game List Styles */
.game-list {
  display: flex;
  justify-content: center;
  gap: 40px;
  margin: 20px;
}

.game-item {
  width: 200px;
  text-align: center;
  position: relative;
  z-index: 10;
}

.game-item img {
  width: 100%;
  border-radius: 10px;
  transition: filter 0.3s ease;
}

.game-item:hover img {
  filter: blur(5px);
}

.game-item .game-info {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 10px;
  z-index: 1;
  visibility: hidden;
  opacity: 0;
  transition: visibility 0s, opacity 0.3s ease-in-out;
}

.game-item:hover .game-info {
  visibility: visible;
  opacity: 1;
}

.game-title {
  font-size: 18px;
  color: white;
  font-weight: bold;
  position: absolute;
  bottom: 25px;
  left: 10px;
  z-index: 2;
}

.game-subtitle {
  font-size: 16px;
  color: white;
  position: absolute;
  bottom: -5px;
  left: 10px;
  z-index: 2;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
}

/* Footer Styles */
footer {
  text-align: center;
  padding: 20px;
  background-color: #5C6BC0;
  color: #ffffff;
  font-size: 14px;
}

footer .footer-content {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
}

footer .footer-logo img {
  width: 90px;
  height: auto;
  margin-left: 10px;
}

footer .footer-text p {
  margin-bottom: 5px;
}

/* Search Icon */
.search-icon {
  width: 24px;
  height: 24px;
  object-fit: fill;
}

.search-popup img {
  max-width: 100%;
  max-height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.search-popup {
  display: none;
  position: absolute;
  top: 60px;
  left: 50%;
  transform: translateX(-50%);
  width: 90%;
  max-width: 800px;
  background-color: rgba(74, 68, 88, 0.95);
  border-radius: 15px;
  padding: 20px;
  z-index: 1000;
  max-height: 80vh;
  overflow-y: auto;
}

.search-popup.active {
  display: block;
}

.search-popup-header {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.search-popup-header .search-icon {
  width: 24px;
  height: 24px;
  margin-right: 10px;
  color: white;
}

/* Search Results */
.search-results {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.search-result-item {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  padding: 15px;
  cursor: pointer;
  border-radius: 10px;
  transition: background-color 0.3s;
  text-decoration: none;
  color: white;
}

.search-result-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

/* Overlay */
.search-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
}

.search-overlay.active {
  display: block;
}

.no-results {
  text-align: center;
  padding: 20px;
  color: white;
  font-size: 18px;
}

</style>

<body>

  <!-- Header Section -->
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
    aria-controls="offcanvasMenu">
    ☰
  </button>
  <div class="offcanvas offcanvas-start custom-offcanvas" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">
            <img src="btc.png" class="logo" alt="BTC Logo">
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="dashboard.php" class="nav-link text-white active">
        <i class="fas fa-home"></i> HOME
      </a>
    </li>
    <li class="nav-item">
      <a href="list_of_games.php" class="nav-link text-white">
        <i class="fas fa-gamepad"></i> LIST OF GAMES
      </a>
    </li>
    <li class="nav-item">
      <a href="profile.php" class="nav-link text-white">
        <i class="fas fa-user"></i> ACCOUNT
      </a>
    </li>
  </ul>
</div>

</div>

  <header class="header">
    <div class="header-left">
      <div class="header-logo">
        <img src="btc.png" alt="BTC Logo">
      </div>
      <div class="search-bar">
        <input type="text" placeholder="Search Game" id="searchInput">
      </div>
    </div>
  </header>

  <!-- Search Popup -->
  <div class="search-overlay" id="searchOverlay"></div>
  <div class="search-popup" id="searchPopup">
    <div class="search-popup-header">
      <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      <h3 id="searchTerm"></h3>
    </div>
    <div class="search-results" id="searchResults">
      <!-- Search results will be inserted here -->
    </div>
  </div>

  <!-- Banner Section -->
  <section class="banner">
  </section>

  <div class="divider">
    <h2>Daftar Game</h2>
  </div>

<!-- Game List Section -->
<section class="game-list">
  <!-- Game Item 1 -->
  <div class="game-item">
    <a href="produk1_pembeli.php">
      <img src="pubg.jpg" alt="PUBG">
      <div class="game-info">
        <h2 class="game-title">PUBG Mobile</h2> <!-- Teks di atas -->
        <p class="game-subtitle">Tencent Games</p> <!-- Teks di bawah -->
      </div>
    </a>
  </div>

  <!-- Game Item 2 -->
  <div class="game-item" data-description="PUBG - Game battle royale action">
    <a href="produk2_pembeli.php">
      <img src="mobile_legends.jpg" alt="Mobile Legends">
      <div class="game-info">
        <h2 class="game-title">Mobile Legends</h2> <!-- Teks di atas -->
        <p class="game-subtitle">Moonton</p> <!-- Teks di bawah -->
      </div>
    </a>
  </div>

  <!-- Game Item 3 -->
  <div class="game-item">
    <a href="produk3_pembeli.php">
      <img src="freefire.jpg" alt="Free Fire">
      <div class="game-info">
        <h2 class="game-title">Free Fire</h2> <!-- Teks di atas -->
        <p class="game-subtitle">Garena</p> <!-- Teks di bawah -->
      </div>
    </a>
  </div>
</section>


  <!-- Footer Section -->
  <footer>
    <div class="footer-content">
      <div class="footer-logo">
        <img src="btc.png" alt="BTC Logo">
      </div>
      <div class="footer-text">
        <p>Nikmati kemudahan top-up diamond game favorit Anda menggunakan BTC Top Up Game Store!</p>
      </div>
    </div>
    <p>© 2025 BTC Top Up Game Store. All Right Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- js ini mengatur fitur popup pencarian-->
  <script src="js_dashboardp.js"></script>

</body>

</html>