  <div class="w-full flex items-center justify-between px-4 py-2 bg-transparent">
    <!-- Kiri: Logo + Menu Burger -->
    <div class="flex items-center space-x-2">
      <!-- Logo Mole -->
      <a href="/" class="flex items-center space-x-2">
        <img src="/images/mole.png" class="h-8" alt="Logo Mole">
      </a>

      <!-- Menu Burger -->
      <button data-collapse-toggle="navbar-hamburger" type="button"
        class="inline-flex items-center justify-center p-2 w-10 h-10 text-sm text-white rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500"
        aria-controls="navbar-hamburger" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
    </div>

    <!-- Tengah: Search Bar -->
    <div class="absolute left-1/2 transform -translate-x-1/2 w-1/3">
      <input type="text" placeholder="Search"
        class="w-full py-2 pl-4 pr-10 rounded-lg border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
      <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </div>
  </div>
