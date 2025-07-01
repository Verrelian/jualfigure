<nav class="w-full border-b border-gray-200 shadow-sm bg-white">
  <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
    <!-- Logo & Brand -->
    <a href="{{ url('/seller/dashboard') }}" class="flex items-center space-x-3">
      <img src="{{ asset('images/icon.png') }}" class="h-12 w-12" alt="M.O.L.E Logo" />
      <span class="text-xl font-semibold text-gray-800">M.O.L.E</span>
    </a>

    @php
        $user = session('user');
    @endphp

    <!-- User Menu -->
    <div class="relative">
      <button type="button" class="flex items-center space-x-2 bg-white text-sm rounded-full px-3 py-1.5 hover:bg-gray-100 focus:ring-2 focus:ring-gray-300" id="user-menu-button" data-dropdown-toggle="user-dropdown">
        <img class="w-8 h-8 rounded-full object-cover"
             src="{{ $user && $user->avatar ? asset('storage/' . $user->avatar) : asset('images/muka.jpg') }}"
             alt="User Avatar">
        <span class="hidden md:block text-gray-700">Profile</span>
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Dropdown -->
      <div class="z-50 hidden mt-2 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg absolute right-0" id="user-dropdown">
        <div class="px-4 py-3 bg-gray-50 rounded-t-lg">
          @if($user)
            <span class="block text-sm font-medium text-gray-900">{{ $user->name }}</span>
            <span class="block text-sm text-gray-500 truncate">{{ $user->email }}</span>
          @else
            <span class="block text-sm text-gray-500">Guest</span>
          @endif
        </div>
        <ul class="py-1">
          <li>
            <a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profil
            </a>
          </li>
          <li>
            <form method="GET" action="{{ route('auth.logout') }}">
              <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-100 text-left">
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
  </div>
</nav>
