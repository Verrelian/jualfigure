<nav class="bg-white shadow">
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-2">
          <img src="{{ asset('images/icon.png') }}" class="h-9 md:h-12 w-auto" alt="Logo" />
          <span class="text-xl font-bold tracking-wide text-gray-800">M.O.L.E</span>
        </a>

      <!-- Menu Links (Desktop) -->
      <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
        <a href="{{ url('/feed') }}"
          class="flex items-center gap-2 border-b-2 border-transparent hover:border-blue-600 text-gray-700 hover:text-blue-600 transition-all py-2">
          <i class="fas fa-rss"></i> Feed
        </a>

        <a href="{{ url('/explore') }}"
          class="flex items-center gap-2 border-b-2 border-transparent hover:border-blue-600 text-gray-700 hover:text-blue-600 transition-all py-2">
          <i class="fas fa-compass"></i> Explore
        </a>

        <a href="{{ url('/wishlist') }}"
          class="flex items-center gap-2 {{ Request::is('wishlist') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600' }} transition-all py-2">
          <i class="fas fa-heart"></i> Wishlist
        </a>

        <a href="{{ route('history.placed') }}"
          class="flex items-center gap-2 {{ request()->routeIs('history.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600' }} transition-all py-2">
          <i class="fas fa-clock-rotate-left"></i> History
        </a>

        <a href="{{ url('/leaderboard') }}"
          class="flex items-center gap-2 {{ Request::is('leaderboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600' }} transition-all py-2">
          <i class="fas fa-trophy"></i> Leaderboard
        </a>

        <a href="{{ route('cart.index') }}"
          class="flex items-center gap-2 {{ Request::is('cart') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600' }} transition-all py-2">
          <i class="fas fa-shopping-cart"></i> Cart
        </a>
      </div>
      <!-- User Menu -->
      @if(session('user'))
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" type="button"
          class="flex items-center space-x-2 text-sm bg-gray-100 rounded-full p-1 hover:bg-gray-200 focus:ring-2 focus:ring-gray-300">
          <img class="w-8 h-8 rounded-full"
            src="{{ session('user')->avatar ? asset('storage/' . session('user')->avatar) : asset('images/muka.jpg') }}"
            alt="User Image">
          <span class="hidden md:block text-gray-700 pr-2">Profile</span>
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.away="open = false" x-transition
          class="absolute right-0 mt-2 w-56 bg-white divide-y divide-gray-100 rounded-lg shadow-lg z-50">
          <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
            <span class="block text-sm font-medium text-gray-900">{{ session('user')->name }}</span>
            <span class="block text-sm text-gray-500 truncate">{{ session('user')->email }}</span>
          </div>
          <ul class="py-2">
            <li>
              <a href="{{ route('user.profile') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil
              </a>
            </li>
            <li>
              <form method="GET" action="{{ route('auth.logout') }}">
                <button type="submit"
                  class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-100 text-left">
                  <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Keluar
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
      @else
      <!-- Guest Login -->
      <a href="{{ route('login') }}"
        class="text-sm text-gray-700 border px-4 py-1 rounded hover:bg-gray-100">Login</a>
      @endif

      <!-- Mobile Menu Button -->
      <button type="button"
        class="inline-flex md:hidden items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-gray-200"
        @click="mobileOpen = !mobileOpen" x-data="{ mobileOpen: false }" x-show="!mobileOpen">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden mt-2 space-y-2" x-show="mobileOpen" x-data="{ mobileOpen: false }">
      <a href="{{ url('/feed') }}" class="block text-gray-700 px-3 py-2 rounded hover:bg-gray-100">Feed</a>
      <a href="{{ url('/explore') }}" class="block text-gray-700 px-3 py-2 rounded hover:bg-gray-100">Explore</a>
      <a href="{{ url('/wishlist') }}" class="block text-gray-700 px-3 py-2 rounded hover:bg-gray-100">Wishlist</a>
      <a href="{{ route('history.placed') }}" class="block text-gray-700 px-3 py-2 rounded hover:bg-gray-100">History</a>
      <a href="{{ url('/leaderboard') }}" class="block text-gray-700 px-3 py-2 rounded hover:bg-gray-100">Leaderboard</a>
    </div>
  </div>
</nav>
