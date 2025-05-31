<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Figure Collection Store')</title>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen flex flex-col bg-[#FFFAFA] text-gray-800">
    @include('component.seller.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('component.footer')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            window.addEventListener('storage', function(e) {
                if (e.key === 'wishlist') updateWishlistCount();
            });
        });
    </script>
</body>

</html>