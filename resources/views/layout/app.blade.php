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

</head>
<body class="min-h-screen" style="background: linear-gradient(to bottom, #C5C4C0, #777284);">
   <!-- navbar -->
    @include('component.navbar')


    <!-- Main Content -->
    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('component.footer')

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Update wishlist count in the navigation
    function updateWishlistCount() {
        const wishlistCountElement = document.getElementById('wishlistCount');
        if (wishlistCountElement) {
            const wishlist = localStorage.getItem('wishlist');
            const wishlistItems = wishlist ? JSON.parse(wishlist) : [];
            wishlistCountElement.textContent = wishlistItems.length;
            
            // Show/hide count based on whether there are items
            if (wishlistItems.length > 0) {
                wishlistCountElement.classList.remove('hidden');
            } else {
                wishlistCountElement.classList.add('hidden');
            }
        }
    }
    
    // Initialize the wishlist count
    updateWishlistCount();
    
    // Listen for storage changes to update count when wishlist is modified from other pages
    window.addEventListener('storage', function(e) {
        if (e.key === 'wishlist') {
            updateWishlistCount();
        }
    });
});
    </script>
</body>
</html>