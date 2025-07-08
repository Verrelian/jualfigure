<!DOCTYPE html>
<html lang="en">
<head>
    @include('component.seller.navbar')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Figure Collection Store')</title>

    <!-- Tailwind & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


    <!-- Flowbite (untuk komponen modal/dll) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <!-- CSRF Token (untuk AJAX atau JS) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-900">

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer (jika ada) --}}
    @include('component.footer')

    {{-- Script Section --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

    {{-- Wishlist Count JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateWishlistCount() {
                const wishlistCountElement = document.getElementById('wishlistCount');
                if (wishlistCountElement) {
                    const wishlist = localStorage.getItem('wishlist');
                    const wishlistItems = wishlist ? JSON.parse(wishlist) : [];
                    wishlistCountElement.textContent = wishlistItems.length;
                    wishlistCountElement.classList.toggle('hidden', wishlistItems.length === 0);
                }
            }
            updateWishlistCount();

            window.addEventListener('storage', function (e) {
                if (e.key === 'wishlist') updateWishlistCount();
            });
        });
    </script>

</body>
</html>
