<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-b from-gray-300 to-gray-100 text-black min-h-screen p-4" x-data="{ tab: 'posts' }">

  <!-- Header -->
  <div class="bg-black text-white py-3 px-4 flex justify-between items-center rounded-lg shadow">
    <div class="text-xl font-bold">User Profile</div>
    <div class="space-x-3">
      <button><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg></button>
      <button><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V13a6.002 6.002 0 00-4-5.659V7a2 2 0 10-4 0v.341C7.67 8.165 6 10.388 6 13v1.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg></button>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex flex-col lg:flex-row gap-6 mt-6">

    <!-- Left Column -->
    <div class="flex-1 space-y-4">
      <div class="text-2xl font-semibold">Nickname</div>

      <!-- Tabs -->
      <div class="flex bg-white bg-opacity-60 rounded-full p-1 w-max shadow">
        <button class="px-4 py-1 rounded-full text-sm font-medium transition" 
                :class="{ 'bg-black text-white': tab === 'posts', 'text-black': tab !== 'posts' }" 
                @click="tab = 'posts'">Posts</button>
        <button class="px-4 py-1 rounded-full text-sm font-medium transition" 
                :class="{ 'bg-black text-white': tab === 'toys', 'text-black': tab !== 'toys' }" 
                @click="tab = 'toys'">Toys</button>
      </div>

      <!-- Content -->
      <div x-show="tab === 'posts'" class="mt-4 space-y-2">
        <p class="text-gray-600">This is where user's posts would appear.</p>
        <button class="bg-black text-white px-4 py-2 rounded-full shadow">New Post</button>
      </div>

      <div x-show="tab === 'toys'" class="mt-4 space-y-4">
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
          <div class="bg-white rounded-lg shadow text-center py-2">Toys name</div>
          <div class="bg-white rounded-lg shadow text-center py-2">Toys name</div>
          <div class="bg-white rounded-lg shadow text-center py-2">Toys name</div>
          <div class="bg-white rounded-lg shadow text-center py-2">Toys name</div>
        </div>
        <div class="flex gap-3">
          <button class="bg-black text-white px-4 py-2 rounded-full shadow">Store</button>
          <button class="bg-black text-white px-4 py-2 rounded-full shadow">New Post</button>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="bg-white bg-opacity-80 rounded-xl p-4 w-full max-w-xs shadow-lg text-center space-y-4">
      <div class="w-24 h-24 bg-black rounded-full mx-auto flex items-center justify-center text-white text-2xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h3m-6 0h.01M9 12H6m3-4h.01M9 16h.01M13 16h.01M13 8h.01M17 8h.01M17 16h.01" />
        </svg>
      </div>
      <h2 class="text-lg font-bold">TITLE</h2>
      <div class="font-semibold text-lg">Nickname</div>
      <div class="flex justify-center gap-6 text-sm">
        <div><strong>89k</strong><br>Followers</div>
        <div><strong>89k</strong><br>Following</div>
      </div>
      <button class="bg-black text-white px-4 py-2 rounded-full w-full shadow">Edit Profile</button>
    </div>

  </div>

</body>
</html>
