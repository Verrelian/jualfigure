<nav class="bg-white shadow">
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-4">

      <!-- Logo -->
      <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3">
        <img src="{{ asset('images/icon.png') }}" class="h-10" alt="M.O.L.E Logo" />
        <span class="text-xl font-semibold text-gray-800">M.O.L.E</span>
      </a>

      <!-- Search Bar -->
      <div class="flex-1 max-w-xl mx-6 hidden md:block">
        <form>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
              </svg>
            </div>
            <input type="search"
                   class="w-full p-2.5 pl-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Cari produk, pelanggan, pesanan..." />
            <button type="submit"
                    class="absolute right-2 bottom-2 text-white bg-blue-600 hover:bg-blue-700 text-xs px-3 py-1 rounded-lg">
              Cari
            </button>
          </div>
        </form>
      </div>

      <!-- Menu Links -->
      <div class="hidden md:flex items-center space-x-6">
        <a href="{{ url('/dashboard') }}"
           class="{{ Request::is('dashboard') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">
          Beranda
        </a>
        <a href="{{ url('/wishlist') }}"
           class="{{ Request::is('wishlist') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">
          Wishlist
        </a>
        <a href="{{ url('/history.placed') }}"
          class="{{ Request::is('history.placed') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">
          History
        </a>
        <a href="{{ url('/leaderboard') }}"
           class="{{ Request::is('leaderboard') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">
          Leaderboard
        </a>
      </div>

      <!-- Profile Dropdown -->
      @if(session('user'))
      <div class="relative">
        <button type="button"
                class="flex items-center space-x-2 text-sm bg-gray-100 rounded-full p-1 hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                id="user-menu-button" data-dropdown-toggle="user-dropdown">
          <img class="w-8 h-8 rounded-full"
               src="{{ session('user')->avatar ? asset('storage/' . session('user')->avatar) : asset('images/muka.jpg') }}"
               alt="User Image">
          <span class="hidden md:block text-gray-700 pr-2">Profile</span>
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <!-- Dropdown menu -->
        <div class="z-50 hidden absolute right-0 mt-2 w-56 bg-white divide-y divide-gray-100 rounded-lg shadow-lg"
             id="user-dropdown">
          <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
            <!--After down-->
            <span class="block text-sm font-medium text-gray-900">{{ session('user')->name }}</span>
            <span class="block text-sm text-gray-500 truncate">{{ session('user')->email }}</span>
            <!-- After UP-->
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
              <a href="{{ route('user.profile') }}"
                 class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
      <!-- Jika guest -->
      <a href="{{ route('login') }}"
         class="text-sm text-gray-700 border px-4 py-1 rounded hover:bg-gray-100">Login</a>
      @endif

      <!-- Mobile Menu Button -->
      <button type="button"
              class="inline-flex md:hidden items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
              aria-controls="mobile-menu" aria-expanded="false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Baris 2: Feed & Explore centered -->
    @if (!View::hasSection('hideFeedExplore'))
    <div class="py-2 flex justify-center space-x-6">
      <a href="{{ url('/feed') }}"
         class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2 font-semibold">
        Feed
      </a>
      <a href="{{ url('/explore') }}"
         class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2 font-semibold">
        Explore
      </a>
    </div>
    @endif
  </div>
</nav>