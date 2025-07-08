      <!-- Search Bar -->
      <div class="flex-1 max-w-xl mx-6 hidden md:block">
      <form action="{{ route('search') }}" method="GET">
        <div class="relative">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="search"
            name="search_keyword"
            class="w-full p-2.5 pl-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Cari produk, pelanggan, pesanan..." required />
          <button type="submit"
            class="absolute right-2 bottom-2 text-white bg-blue-600 hover:bg-blue-700 text-xs px-3 py-1 rounded-lg">
            Cari
          </button>
        </div>
      </form>
      </div>