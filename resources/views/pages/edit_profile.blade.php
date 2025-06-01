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
          <a href="{{ url('/profile') }}" class="hover:underline">Back</a>
        </div>
      </div>

      <div class="p-4">
        <h2 class="text-xl font-bold mb-4 text-center">Settings</h2>

        <div class="flex flex-wrap">
          <div class="w-1/4 pr-4 flex flex-col items-center">
            <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
              <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/150/FF5733/FFFFFF?text=LH' }}" alt="Profile" class="w-full h-full object-cover">
            </div>
            <input type="file" name="avatar" class="text-xs text-gray-700">
          </div>

          <div class="w-3/4">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
              @csrf
              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Name:</label>
                  <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Username:</label>
                  <input type="text" name="username" value="{{ $user->username }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
              </div>

              <div class="mb-3">
                <label class="block text-gray-600 text-xs mb-1">Email:</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
              </div>

              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Nickname:</label>
                  <input type="text" name="nickname" value="{{ $user->nickname }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Country:</label>
                  <input type="text" name="country" value="{{ $user->country }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
              </div>

              <div class="flex mb-3 space-x-3">
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Birthdate:</label>
                  <input type="date" name="birthdate" value="{{ $user->birthdate }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
                <div class="w-1/2">
                  <label class="block text-gray-600 text-xs mb-1">Phone:</label>
                  <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border border-gray-300 rounded p-1.5 text-sm">
                </div>
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
