<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Toys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
    <div class="max-w-lg mx-auto my-4">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header with Menu -->
            <!-- Header with Dropdown Menu -->
<div class="bg-black text-white p-3 relative">
    <div class="flex justify-start items-center">
        <!-- Menu Button -->
        <button id="menu-button" class="focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Dropdown Menu -->
    <div id="dropdown-menu"
        class="absolute top-12 left-3 bg-white text-black rounded-lg shadow-lg w-40 hidden z-50">
        <a href="/webs" class="block px-4 py-2 hover:bg-gray-100">Home</a>
        <a href="/" class="block px-4 py-2 hover:bg-gray-100">List Product</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
    </div>
</div>
            
            <!-- Profile Content -->
            <div class="flex">
                <!-- Left side (Profile info & toys) -->
                <div class="w-2/3 p-4">
                    <div class="flex items-center mb-3">
                        <h2 class="text-xl font-bold">Stephen Hawking</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="flex space-x-4 mb-4">
                        <button id="posts-tab" class="px-4 py-1 bg-gray-200 rounded-md text-sm font-medium">Posts</button>
                        <button id="toys-tab" class="px-4 py-1 bg-gray-200 rounded-md text-sm font-medium text-blue-500 border-b-2 border-blue-500">Toys</button>
                    </div>
                    
                    <!-- Toys Collection -->
                    <div class="grid grid-cols-5 gap-3 mb-6">
                        <!-- Toy 1 -->
                        <div class="flex flex-col items-center">
                            <div class="bg-yellow-100 rounded-md p-2 w-full flex justify-center mb-1">
                                <div class="w-8 h-10 bg-yellow-600"></div>
                            </div>
                            <span class="text-xs text-gray-500">Golden Toy</span>
                        </div>
                        
                        <!-- Toy 2 -->
                        <div class="flex flex-col items-center">
                            <div class="bg-green-100 rounded-md p-2 w-full flex justify-center mb-1">
                                <div class="w-8 h-10 bg-green-600"></div>
                            </div>
                            <span class="text-xs text-gray-500">Emerald</span>
                        </div>
                        
                        <!-- Toy 3 -->
                        <div class="flex flex-col items-center">
                            <div class="bg-purple-100 rounded-md p-2 w-full flex justify-center mb-1">
                                <div class="w-8 h-10 bg-purple-600"></div>
                            </div>
                            <span class="text-xs text-gray-500">Wizard</span>
                        </div>
                        
                        <!-- Toy 4 -->
                        <div class="flex flex-col items-center">
                            <div class="bg-pink-100 rounded-md p-2 w-full flex justify-center mb-1">
                                <div class="w-8 h-10 bg-pink-600"></div>
                            </div>
                            <span class="text-xs text-gray-500">Princess</span>
                        </div>
                        
                        <!-- Toy 5 -->
                        <div class="flex flex-col items-center">
                            <div class="bg-teal-100 rounded-md p-2 w-full flex justify-center mb-1">
                                <div class="w-8 h-10 bg-teal-600"></div>
                            </div>
                            <span class="text-xs text-gray-500">Emerald</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <button id="view-post-btn" class="bg-black text-white rounded-full px-6 py-2 text-sm font-medium">View Post</button>
                        <button id="view-toys-btn" class="bg-gray-200 text-black rounded-full px-6 py-2 text-sm font-medium">View Toys</button>
                    </div>
                </div>
                
                <!-- Right side (User info) -->
                <div class="w-1/3 p-4 bg-gray-50">
                    <div class="flex flex-col items-center">
                        <!-- Profile Image -->
                        <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
                            <img src="image/muka.jpg" alt="Profile" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- User Info -->
                        <div class="text-center">
                            <h3 class="font-bold">Loyal Hunter</h3>
                            <p class="text-sm text-gray-600">Stephen Hawking</p>
                            
                            <!-- Counts -->
                            <div class="flex justify-center space-x-6 my-2 text-xs">
                                <div>
                                    <p class="text-gray-500">Followers</p>
                                    <p class="font-bold">58k</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Following</p>
                                    <p class="font-bold">28k</p>
                                </div>
                            </div>
                            
                            <!-- Edit Profile Button -->
                            <button id="edit-profile-btn" class="bg-black text-white rounded-lg w-full py-1 text-sm mt-2">Edit Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Button functionality
        document.getElementById('posts-tab').addEventListener('click', function() {
            // Switch to posts tab
            this.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
            document.getElementById('toys-tab').classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            // Additional logic to show posts content
        });
        
        document.getElementById('toys-tab').addEventListener('click', function() {
            // Switch to toys tab
            this.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
            document.getElementById('posts-tab').classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
            // Additional logic to show toys content
        });
        
        document.getElementById('view-post-btn').addEventListener('click', function() {
            // Navigate to posts view
            document.getElementById('posts-tab').click();
        });
        
        document.getElementById('edit-profile-btn').addEventListener('click', function () {
    window.location.href = "{{ route('profile.edit') }}";
});

        
        // Toggle Dropdown Menu
    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    menuButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Optional: klik di luar dropdown untuk menutup
    window.addEventListener('click', function (e) {
        if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
    </script>
</body>
</html>