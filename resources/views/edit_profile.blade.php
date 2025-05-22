<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300">
  <div class="max-w-lg mx-auto my-6">
    <!-- Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <!-- Header -->
      <div class="bg-black text-white p-4 flex items-center justify-between">
        <img src="{{ asset('images/icon.png') }}" alt="Mole Logo" class="w-10">
        <div class="hidden md:flex space-x-4">
          <a href="{{ url('/profile') }}" class="hover:underline">Back</a>
        </div>
        <button id="hamburger-btn" class="md:hidden">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path d="M4 5h16M4 12h16M4 19h16" />
          </svg>
        </button>
      </div>

      <!-- Content -->
      <div class="p-4">
        <h2 class="text-xl font-bold mb-4 text-center">Settings</h2>

        <div class="flex flex-wrap">
          <!-- Left - Avatar -->
          <div class="w-1/4 pr-4 flex flex-col items-center">
            <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
              <img src="https://via.placeholder.com/150/FF5733/FFFFFF?text=LH" alt="Profile" class="w-full h-full object-cover">
            </div>
            <button class="bg-gray-200 text-gray-800 rounded px-2 py-1 text-xs">Upload Photo</button>
          </div>

          <!-- Right - Form -->
          <div class="w-3/4">
            <form>
              <!-- Username & Email -->
              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Username:</label>
                  <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Email:</label>
                  <input type="email" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
              </div>

              <!-- Name, Nickname -->
              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Name:</label>
                  <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Nickname:</label>
                  <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
              </div>

              <!-- Country -->
              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Country:</label>
                <select class="w-full border border-gray-300 rounded p-1.5 text-sm bg-white">
                  <option>Indonesia</option>
                  <option>USA</option>
                  <option>UK</option>
                  <option>Canada</option>
                  <option>Australia</option>
                </select>
              </div>

              <!-- Birthdate, Phone -->
              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Birthdate:</label>
                  <input type="date" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Phone:</label>
                  <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
              </div>

              <!-- Address -->
              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Address:</label>
                <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <!-- Bio -->
              <div class="mb-4">
                <label class="block text-gray-600 text-xs mb-1">Bio:</label>
                <textarea class="w-full border border-gray-300 rounded p-2 text-sm h-24"></textarea>
              </div>

              <!-- Action Buttons -->
              <div class="flex space-x-2">
                <button type="submit" class="bg-black text-white rounded px-4 py-1 text-sm">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
