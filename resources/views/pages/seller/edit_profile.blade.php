<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-8">
  <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-black text-white p-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/icon.png') }}" alt="Mole Logo" class="w-10 h-10 object-cover">
        <h1 class="text-lg font-semibold">Edit Profile</h1>
      </div>
      <a href="{{ route('seller.profile') }}" class="text-sm hover:underline">Back</a>
    </div>

    <!-- Content -->
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Profile Settings</h2>

      <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Avatar -->
        <div class="flex flex-col md:flex-row items-center gap-4">
          <div class="flex-shrink-0">
            <div class="w-24 h-24 rounded-full overflow-hidden border">
              <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/muka.jpg') }}"
                   alt="Profile" class="w-full h-full object-cover">
            </div>
          </div>
          <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
            <input type="file" name="avatar" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            @if (session('seller')['avatar'] ?? false)
              <img src="{{ asset('storage/avatars/' . session('seller')['avatar']) }}" alt="Foto Profil" class="w-16 mt-2 rounded">
            @endif
          </div>
        </div>

        <!-- Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Birthdate</label>
            <input type="date" name="birthdate" value="{{ $user->birthdate }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
            <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <input type="text" name="address" value="{{ $user->address }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
          </div>
        </div>

        <!-- Bio -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
          <textarea name="bio" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 text-sm resize-none">{{ $user->bio }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-black text-white rounded px-6 py-2 text-sm hover:bg-gray-800 transition">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
