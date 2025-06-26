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
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="bg-black text-white p-4 flex items-center justify-between">
        <img src="{{ asset('images/icon.png') }}" alt="Mole Logo" class="w-10">
        <div class="hidden md:flex space-x-4">
          <a href="{{ route('seller.profile') }}" class="hover:underline">Back</a>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-xl font-bold mb-4 text-center">Settings</h2>

        <div class="flex flex-wrap">
          <div class="w-1/4 pr-4 flex flex-col items-center">
            <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
              <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/muka.jpg') }}"
                   alt="Profile" class="w-full h-full object-cover">
            </div>
          </div>

          <div class="w-3/4">
            <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
              @csrf

              <div class="mb-4">
  <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
  <input type="file" name="avatar" class="border rounded w-full p-2" accept="image/*">
  @if (session('seller')['avatar'] ?? false)
    <img src="{{ asset('storage/avatars/' . session('seller')['avatar']) }}" alt="Foto Profil" class="w-20 mt-2 rounded">
  @endif
</div>


              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Name:</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Username:</label>
                <input type="text" name="username" value="{{ $user->username }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Email:</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>
              <div class="mb-3">
  <label class="block text-gray-600 text-xs mb-1">Birthdate:</label>
  <input type="date" name="birthdate" value="{{ $user->birthdate }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
</div>

              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Phone Number:</label>
                <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Address:</label>
                <input type="text" name="address" value="{{ $user->address }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <div class="mb-4">
                <label class="block text-gray-600 text-xs mb-1">Bio:</label>
                <textarea name="bio" class="w-full border border-gray-300 rounded p-2 text-sm h-24">{{ $user->bio }}</textarea>
              </div>

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
