<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Top Bar -->
    <div class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-bold">MOLE</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600"> Profile User</span>
            <button id="back-btn" class="text-sm bg-gray-200 px-4 py-1 rounded">Back</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto mt-6 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Sidebar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg p-6 shadow-sm flex flex-col items-center">
                <div class="w-40 h-40 rounded-full overflow-hidden mb-4 border-4 border-gray-200">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/muka.jpg') }}" alt="Profile" class="w-full h-full object-cover rounded-full">
                </div>
                    <h2 class="text-lg font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ $user->username }}</p>

                <!-- Informasi Tambahan -->
                <div class="w-full text-sm text-gray-600 space-y-1 text-left mt-2">
                    <p><strong>Tanggal Lahir:</strong> {{ $user->birthdate ?? '-' }}</p>
                    <p><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Alamat:</strong> {{ $user->address ?? '-' }}</p>
                </div>

                <button id="edit-profile-btn" class="bg-black text-white mt-4 w-full py-2 text-sm rounded-md">Edit Profile</button>
            </div>
        </div>

        <!-- Main Section -->
        <div class="md:col-span-2 space-y-6">

            <!-- Toys Collection -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-xl font-semibold mb-4">Toys Collection</h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ([
                        'Golden Toy' => 'bg-yellow-500',
                        'Emerald' => 'bg-green-500',
                        'Wizard' => 'bg-purple-500',
                        'Princess' => 'bg-pink-500',
                        'Ninja' => 'bg-teal-500'
                    ] as $name => $color)
                        <div class="flex flex-col items-center">
                            <div class="rounded-md p-3 w-full flex justify-center mb-1 bg-opacity-20 {{ $color }}">
                                <div class="w-10 h-12 rounded {{ $color }}"></div>
                            </div>
                            <span class="text-xs text-gray-600">{{ $name }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex gap-3">
                    <button id="view-post-btn" class="bg-black text-white rounded-full px-6 py-2 text-sm font-medium">View Post</button>
                    <button id="view-toys-btn" class="bg-gray-200 text-black rounded-full px-6 py-2 text-sm font-medium">View Toys</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.getElementById('edit-profile-btn').addEventListener('click', function () {
            window.location.href = "{{ route('user.profile.edit') }}";
        });

        document.getElementById('back-btn').addEventListener('click', function () {
            window.location.href = "{{ route('dashboard') }}";
        });

        document.getElementById('view-post-btn').addEventListener('click', function () {
            window.location.href = "{{ route('user.posts') }}";
        });

        document.getElementById('view-toys-btn').addEventListener('click', function () {
            window.location.href = "{{ route('user.toys') }}";
        });
    </script>

</body>
</html>
