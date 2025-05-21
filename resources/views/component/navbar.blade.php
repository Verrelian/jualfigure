<nav class="bg-white border-b border-gray-200 shadow-sm">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-3">
    <!-- Logo dan Brand -->
    <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3">
    <img src="{{ asset('images/icon.png') }}" class="h-10" alt="M.O.L.E Logo" />
      <span class="self-center text-xl font-semibold whitespace-nowrap text-gray-800">M.O.L.E</span>
    </a>

    <!-- Search Bar -->
    <div class="flex-1 max-w-xl mx-6">
      <form>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="search" class="block w-full p-2.5 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari produk, pelanggan, pesanan..." />
          <button type="submit" class="absolute end-2.5 bottom-2 text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1">
            Cari
          </button>
        </div>
      </form>
    </div>

    <!-- Navigation and User Menu -->
    <div class="flex items-center">
      <!-- Main Navigation -->
      <div class="hidden md:flex md:space-x-6 me-6">
          <a href="{{ url('/dashboard') }}" class="{{ Request::is('/dashboard') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">Home</a>

          <a href="{{ url('/wishlist') }}" class="{{ Request::is('seller/crud') ? 'text-blue-600 font-medium border-b-2 border-blue-600' : 'text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600' }} py-2">Whislist</a>

          <a href="{{url ('/leaderboard') }}" class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2">Leaderboard</a>

          <a href="{{url ('/explore') }}" class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2">Explore</a>

          <a href="{{url ('/order-history') }}" class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2">Order History</a>

          <a href="{{url ('/post') }}" class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2">Add Post</a>

          <a href="{{url ('/feed') }}" class="text-gray-700 hover:text-blue-600 hover:border-b-2 hover:border-blue-600 py-2">Feed</a>
      </div>


      <!-- User Dropdown - Profile Penjual -->
      <div class="relative">
        <button type="button" class="flex items-center space-x-2 text-sm bg-gray-100 rounded-full p-1 hover:bg-gray-200 focus:ring-2 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="/images/icon.png" alt="user photo">
          <span class="hidden md:block text-gray-700 pe-2">Profile</span>
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <!-- Dropdown menu -->
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg" id="user-dropdown">
          <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
            <span class="block text-sm font-medium text-gray-900">Adnan</span>
            <span class="block text-sm text-gray-500 truncate">email@and.com</span>
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
              <a href="/mole/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 me-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profil
              </a>
            </li>
              <!-- Tombol Logout -->
              <a href="#" onclick="logout()" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 me-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                  </path>
                </svg>
                Keluar
              </a>

              <!-- Script Logout -->
              <script>
                function logout() {
                  localStorage.removeItem('currentUser');
                  window.location.href = '/mole/login';
                }
              </script>

            </li>
          </ul>
        </div>
      </div>

      <!-- Mobile menu button -->
      <button type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </div>