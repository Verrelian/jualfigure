<!-- resources/views/component/navbar.blade.php -->
<nav class="bg-gray-900 text-white shadow-lg">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    <!-- Logo Saja -->
    <a href="/" class="flex items-center space-x-2">
      <img src="/image/logo.jpeg" class="h-8" alt="Logo Mole" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Mole</span>
    </a>

    <!-- Search Bar -->
    <div class="relative w-full mt-4 md:mt-0 md:w-64">
      <input type="text" placeholder="Search"
        class="w-full py-2 px-4 rounded-lg border border-gray-300 text-gray-900">
      <button class="absolute right-2 top-1/2 transform -translate-y-1/2">
        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </div>
<button data-collapse-toggle="navbar-hamburger" type="button" class="inline-flex items-center justify-center p-2 w-10 h-10 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-hamburger" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
      </svg>
  </div>
</nav>
