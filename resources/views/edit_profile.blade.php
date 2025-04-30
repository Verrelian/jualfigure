<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300">
    <div class="max-w-lg mx-auto my-4">
        <!-- Profile Edit Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
           <!-- Header/Menu -->
<div class="bg-black text-white p-4">
    <div class="flex items-center justify-between">

        <img src="{{ asset('images/icon.png') }}" alt="Mole Logo" class="w-10"> <!-- Ganti 'path_to_your_logo.png' dengan path logo yang kamu inginkan -->
        <div class="text-lg font-bold">
        </div>

        <!-- Hamburger Icon (Desktop) -->
        <div class="md:flex hidden">
            <button id="hamburger-btn" class="focus:outline-none">
                <!-- Icon garis tiga -->
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M4 5h16M4 12h16M4 19h16" />
                </svg>
            </button>
        </div>

        <!-- Menu (Desktop) -->
        <div class="hidden md:flex space-x-4">
            <a href="{{ url('/profile') }}" class="hover:underline">Back</a>
        </div>
    </div>
</div>

            
            <!-- Settings Content -->
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4 text-center">Settings</h2>
                
                <div class="flex flex-wrap">
                    <!-- Left Column - Profile Image -->
                    <div class="w-1/4 pr-4 flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full overflow-hidden mb-2">
                            <img src="https://via.placeholder.com/150/FF5733/FFFFFF?text=LH" alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <button class="bg-gray-200 text-gray-800 rounded px-2 py-1 text-xs">Upload Photo</button>
                    </div>
                    
                    <!-- Right Column - Form Fields -->
                    <div class="w-3/4">
                        <form>
                            <!-- First Row -->
                            <div class="flex mb-3 space-x-3">
                                <div class="w-1/2">
                                    <label class="block text-gray-600 text-xs mb-1">Username:</label>
                                    <input type="text" class="w-full border border-gray-300 rounded p-1.5 text-sm" value="">
                                </div>
                                <div class="w-1/2">
                                    <label class="block text-gray-600 text-xs mb-1">Email:</label>
                                    <input type="email" class="w-full border border-gray-300 rounded p-1.5 text-sm" value="">
                                </div>
                            </div>
                        
                                </div>
                                <div class="w-1/3">
                                    <label class="block text-gray-600 text-xs mb-1">Country:</label>
                                    <select class="w-full border border-gray-300 rounded p-1.5 text-sm bg-white">
                                        <option>India</option>
                                        <option>USA</option>
                                        <option>UK</option>
                                        <option>Canada</option>
                                        <option>Australia</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Bio Field -->
                            <div class="mb-4">
                                <label class="block text-gray-600 text-xs mb-1">Bio:</label>
                                <textarea class="w-full border border-gray-300 rounded p-2 text-sm h-24"></textarea>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2 justify-start">
                                <button type="submit" class="bg-black text-white rounded px-4 py-1 text-sm">Save</button>
                                <button type="button" class="bg-red-500 text-white rounded px-4 py-1 text-sm">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>